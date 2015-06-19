<?php
/*
*	FileDialog 
*	for PHP-GTK
*	by Christian Weiske, cweiske@cweiske.de
*
*	version: 0.0.2 beta
*	last change: 2002-10-29 23:32
*
*	This script is freeware.
*	You can use it as long you leave this copyright notice where it is.
*
*	The FileDialog function is similar to the (Visual)C++ MFC function CFileDialog
*	Many styles are supported and named exactly like the original constants
*
*	It requires the MessageBox function + class written by Christian Weiske
*
*	The script has been tested on Windows XP and should(!) work under all other Platforms.
*	If you find a bug, please tell me! Bugfixes are highly appreciated.
*
*
*	Known bugs:
*	- differences between $nFlags on 0 and NULL: 
*		- on NULL, the flags OFN_HIDEREADONLY + OFN_OVERWRITEPROMPT + OFN_ENABLESIZING are set
*		- on 0, no flags are set
*		This is NO bug, this is a feature.
*	- FileDialog crashes if you give an array( &$not_existing_object, "function") 
*		and click on the Help button
*
*
*	Known limitations:
*	*I've tried to avoid limitations. All things listed here canNOT work (IMHO)*
*	*If you find a workaround, please tell me!*
*
*	- instead of using a string for the filter values (original C++ function), you have to use an array 
*		-> see	"$arFilter array" some lines below
*		I had such a thing in, but the array got sorted and additionally I think no one needs this.
*		The array solution is better.
*
*	- just one file type filter can be used on a file type, not several like in the original
*		e.g.: 
*		- original: "files|*.txt;*.ini||"
*		- this: array( "files" => "*.txt;*.ini") DOESNT work, you can use only one like
*		- array( "TXT files" => "*.txt", "INI files" => "*.ini") works
*		This limitation depends on the complete()-function internally used by GtkFileDialog
*
*	- filetype filter: GtkFileDialog hides folders as well as files, 
*		which (folder hiding) is not wanted on file selection
*
*	- filetype filter: GtkFileDialog switches back to "*" on DirChange
*
*	- OFN_NOCHANGEDIR: directory movement with TAB key in file entry is possible, 
*		cause I can't stop the TAB signal (it isn't even captured @ button-press-event)
*		(but the dir is reset to the default when clicking "OK")
*
*	- OFN_ALLOWMULTISELECT used on a SaveFileDialog is nonsense, I think.
*		So there is no extra auto-title-text for this constellation
*
*
*	Hints:
*	- The $strHelpfunction is only used for the help button.
*		it can be a string or an array with max. 3 elements
*		if is is NULL, the function OnHelp( "savefiledialog") or OnHelp( "openfiledialog") is called when the user
*		clicks on the button Help
*		Examples:
*			"OnHelp"						=> function OnHelp( "[open|save]filedialog") is called
*			array( "OnHelp", "parameter")	=> function OnHelp( "parameter") is called
*			array( $clsClass, "OnHelp")		=> $clsClass->OnHelp( "[open|save]filedialog") is called
*			array( $clsClass, "OnHelp", "p")=> $clsClass->OnHelp( "p") is called
*
*	- $arFilter: array:
*		Usage:		array with array keys as description and wildcard string as value
*					The first entry is used for default!
*		Example:	array( "Chart files (*.xlc)" => "*.xlc", "Data Files (*.xlc;*.xls)" => "*.xlc; *.xls", "All Files (*.*)" => "*.*")
*
*
*
*	TODO
*	- nothing I know... except testing :)
*/


/*
* FileDialog flags
*/
define( "OFN_READONLY"                 ,        1);    // Causes the Read Only check box to be checked initially when the dialog box is created. This flag indicates the state of the Read Only check box when the dialog box is closed.
define( "OFN_OVERWRITEPROMPT"          ,        2);	   // Causes the Save As dialog box to generate a message box if the selected file already exists. The user must confirm whether to overwrite the file.
define( "OFN_HIDEREADONLY"             ,        4);	   // Hides the Read Only check box.
define( "OFN_NOCHANGEDIR"              ,        8);	   // Restores the current directory to its original value if the user changed the directory while searching for files.
define( "OFN_SHOWHELP"                 ,       16);	   // Causes the dialog box to display the Help button.
define( "OFN_NOVALIDATE"               ,       32);	   // Specifies that the common dialog boxes allow invalid characters in the returned filename. 
define( "OFN_ALLOWMULTISELECT"         ,       64);	   // Specifies that the File Name list box allows multiple selections.
define( "OFN_PATHMUSTEXIST"            ,      128);	   // Specifies that the user can type only valid paths. If this flag is used and the user types an invalid path in the File Name entry field, the dialog box function displays a warning in a message box.
define( "OFN_FILEMUSTEXIST"            ,      256);	   // Specifies that the user can type only names of existing files in the File Name entry field. If this flag is specified and the user enters an invalid name, the dialog box procedure displays a warning in a message box. If this flag is specified, the OFN_PATHMUSTEXIST flag is also used.
define( "OFN_CREATEPROMPT"             ,      512);	   // If the user specifies a file that does not exist, this flag causes the dialog box to prompt the user for permission to create the file. If the user chooses to create the file, the dialog box closes and the function returns the specified name; otherwise, the dialog box remains open. If you use this flag with the OFN_ALLOWMULTISELECT flag, the dialog box allows the user to specify only one nonexistent file. 
define( "OFN_ENABLESIZING"             ,     1024);	   // Enables the dialog box to be resized using either the mouse or the keyboard.
define( "OFN_HIDEFILEOPS"              ,     2048);    // Hides the file operation buttons (create dir, delete file, rename file)
define( "OFN_SELECTDIR"                ,     4096);    // Lets the user select a directory



//MessageBox by Christian Weiske is required
if( !class_exists( "MessageBox")) {
	$nAnswer	= @include_once( "GTK_MessageBox.inc");
	if( $nAnswer === false) {
		die( "GTK_MessageBox.inc is required for FileDialog\n");
	}
}


function FileDialog( $bOpenFileDialog, $strDefExt = NULL, $strFileName = NULL, $nFlags = NULL, $arFilter = NULL, $strHelpfunction = NULL)
{
	$FileDlg	= new FileDialog( $bOpenFileDialog, $strDefExt, $strFileName, $nFlags, $arFilter, $strHelpfunction);
	$FileDlg	->DoModal();

	return $FileDlg->strAnswer;
}//function FileDialog( $bOpenFileDialog, $strDefExt = NULL, $strFileName = NULL, $nFlags = NULL, $arFilter = NULL, $strHelpfunction = NULL)


class FileDialog
{
	var $bOpenFileDialog		= false;	// If it is an open file or save file dialog box
	var $strDefExt				= NULL;		// Default extension is appended if the user doesn't specify it in the filename
	var $strFileName			= NULL;		// Default file- and pathname
	var $nFlags					= 0;		// Flags for customizing the dialog box, see "FileDialog flags"
	var $strFilter				= NULL;		// File filter, see "$strFilter values"
	var $arFilter				= array( "All files (*)" => "*");
	var $strHelpfunction		= NULL;
	var $strPathSeparator		= "/";		//Path separator, OS-dependend

	var $strDialogTitle			= "Save file as...";
	var $strAnswer				= false;	// "false" if cancel was clicked, filename if file w/o Multiselect was chosen and array if MULTISELECT was activated
	var $nButton				= NULL;		// Which button was pressed
	var $bReadonly				= NULL;		// If readonly was selected after clicking "OK"

	var $_dlgFile;							// Handle to GtkFileSelection
	var $_arWidgets				= array();	// All additional widgets are referenced here


	
	
	//Constructor
	function FileDialog( $bOpenFileDialog, $strDefExt = NULL, $strFileName = NULL, $nFlags = NULL, $arFilter = NULL, $strHelpfunction = NULL)
	{
		$this->bOpenFileDialog			= $bOpenFileDialog;
		if( $this->bOpenFileDialog == true) {
			if( $nFlags & OFN_ALLOWMULTISELECT) {
				$this->strDialogTitle		= "Select files to open";
			} else {
				$this->strDialogTitle		= "Select file to open";
			}

			if( $nFlags & OFN_SELECTDIR) {
				$this->strDialogTitle		= "Select directory";
			}
		} else {
			$this->strDialogTitle		= "Save file as...";
		}

		$this->strDefExt				= $strDefExt;
		$this->strFileName				= $strFileName;
		$this->nFlags					= $nFlags;
		if( $this->nFlags === NULL) {
			$this->nFlags				= OFN_HIDEREADONLY + OFN_OVERWRITEPROMPT + OFN_ENABLESIZING;
		}

		$this->arFilter					= $arFilter;
		if( $this->arFilter === NULL || count( $this->arFilter) == 0) {
			$this->arFilter				= array( "All files (*)"		=> "*");
		}
		
		$this->strHelpfunction			= &$strHelpfunction;

		strstr( PHP_OS, "WIN") ? $this->strPathSeparator = "\\" : $this->strPathSeparator = "/";
	}//function FileDialog( $bOpenFileDialog, $strDefExt = NULL, $strFileName = NULL, $nFlags = OFN_HIDEREADONLY | OFN_OVERWRITEPROMPT, $strFilter = NULL)




	/*
	*	Displays the dialog box and allows the user to make a selection.
	*	Return value:	IDOK or IDCANCEL
	*/
	function DoModal()
	{
		$dlgFile			= &new GtkFileSelection( $this->strDialogTitle);
		$this->_dlgFile		= &$dlgFile;
		
		$dlgFile			->set_modal( true);

		$this->_arWidgets["ttTooltips"]			= &new GtkTooltips();
		$this->_arWidgets["main_vbox"]			= $dlgFile->main_vbox;

		if( $this->strFileName !== NULL) {
			$this->strFileName	= $this->_RepairPath( $this->strFileName);
			if( strstr( PHP_OS, "WIN")) {
				$dlgFile->set_filename( str_replace( "/", "\\", $this->strFileName));
			} else {
				$dlgFile->set_filename( $this->strFileName);
			}
		}

		//Resize?
		if( !( $this->nFlags & OFN_ENABLESIZING)) {
			$dlgFile		->set_policy( false, false, false);
		}

		
		//File type
		$this->_arWidgets["optmnuFiletype"]		= &new GtkOptionMenu();
		$this->_arWidgets["ttTooltips"]			->set_tip( $this->_arWidgets["optmnuFiletype"], "Select file types to display", "");
		//File type menu
		$this->_arWidgets["mnuFiletype"]		= &new GtkMenu();

		$nItem		= -1;
		foreach( $this->arFilter as $strDescription => $strFilter) {
			$nItem		++;
			if( $nItem == 0) {
				if( $strFilter == "*") {
					$strFilter = "";
				}
				$dlgFile->complete( $strFilter);
			}
			$this->_arWidgets["mnuiFiletype" . $nItem]	= &new GtkMenuItem( $strDescription);
			$this->_arWidgets["mnuiFiletype" . $nItem]	->connect( "activate", array( &$this, "_OnSelectFiletype"), $strFilter);
			$this->_arWidgets["mnuiFiletype" . $nItem]	->show();
			$this->_arWidgets["mnuFiletype"]			->append( $this->_arWidgets["mnuiFiletype" . $nItem]);
		}
		$this->_arWidgets["mnuFiletype"]		->show();
		$this->_arWidgets["optmnuFiletype"]		->set_menu( $this->_arWidgets["mnuFiletype"]);
		
		$action_area	= $dlgFile->action_area;
		$action_area	->set_homogeneous( false);
		$this->_arWidgets["lblFiletype"]		= &new GtkLabel( "Filetype:");
		$this->_arWidgets["lblFiletype"]		->show();
		$action_area->pack_start( $this->_arWidgets["lblFiletype"], false, false, 0);

		$this->_arWidgets["optmnuFiletype"]		->show();
		$action_area->pack_start( $this->_arWidgets["optmnuFiletype"], true, true, 0);


		//Readonly?
		if( !($this->nFlags & OFN_HIDEREADONLY)) {
			$this->_arWidgets["chkReadonly"]		= &new GtkCheckButton( "Readonly");
			if( $this->nFlags & OFN_READONLY) {
				$this->_arWidgets["chkReadonly"]	->set_active( true);
			}
			$this->_arWidgets["ttTooltips"]			->set_tip( $this->_arWidgets["chkReadonly"], "Open the file read-only", "");
			$this->_arWidgets["chkReadonly"]		->show();
			$action_area->pack_start( $this->_arWidgets["chkReadonly"], false, false, 20);
		}

		
		//Help button?
		if( $this->nFlags & OFN_SHOWHELP) {
			$arChildren	= $this->_arWidgets["main_vbox"]->children();

			$this->_arWidgets["btnHelp"]			= &new GtkButton( "Help");
			$this->_arWidgets["btnHelp"]			->set_flags(	GTK_CAN_DEFAULT);
			$this->_arWidgets["ttTooltips"]			->set_tip( $this->_arWidgets["btnHelp"], "Show help on this dialog", "");
			$this->_arWidgets["btnHelp"]			->connect( "clicked", array( &$this, "_OnButtonHelp"));
			$this->_arWidgets["btnHelp"]			->show();
			$arChildren[ count( $arChildren) - 1]	->add( $this->_arWidgets["btnHelp"]);
		}

		//Hide file op buttons?
		if( $this->nFlags & OFN_HIDEFILEOPS) {
			$dlgFile								->hide_fileop_buttons();
		}


		//Select just dir?
		if( $this->nFlags & OFN_SELECTDIR) {
			$arChildren			= $this->_arWidgets["main_vbox"]->children();
			//dir option menu
			$arChildren[1]		->hide();
			
			$arSelChildren		= $arChildren[2]->children();
			//filelist
			$arSelChildren[1]	->hide();
		} 
		else 
		//Don't allow dirchange
		if( $this->nFlags & OFN_NOCHANGEDIR) {
			$arChildren			= $this->_arWidgets["main_vbox"]->children();
			//dir option menu
			$arChildren[1]		->hide();
			
			$arSelChildren		= $arChildren[2]->children();
			//dirlist
			$arSelChildren[0]	->hide();

			$arTxtChildren		= $arChildren[4]->children();
			//This doesn't work cause the TAB key (used for autocomplete) is NOT captured
			//$arTxtChildren[1]	->connect( "key-press-event", array( &$this, "_OnAutocomplete"));
		}


		//Select multiple files?
		if( $this->nFlags & OFN_ALLOWMULTISELECT) {
			$arChildren			= $this->_arWidgets["main_vbox"]->children();
			$arSelChildren		= $arChildren[2]->children();
			$arScrwChildren		= $arSelChildren[1]->children();
			$arScrwChildren[0]	->set_selection_mode( GTK_SELECTION_EXTENDED);
			$this->_arWidgets["lstFiles"]	= &$arScrwChildren[0];
		}
		

		//Connect buttons
		$ok_button		= $dlgFile->ok_button;
		$ok_button		->connect( "clicked", array( &$this, "_OnButtonOK"), $dlgFile);
		$cancel_button	= $dlgFile->cancel_button;
		$cancel_button	->connect( "clicked", array( &$this, "_OnButtonCancel"), "cancel-button");

		$dlgFile		->connect( "delete-event", array( &$this, "_OnButtonCancel"), "delete-event");
		$dlgFile		->show();
		GTK::main();

		return $this->nButton;
	}//function DoModal()





	/*
	*	Call this function to retrieve the full path of the file entered in the dialog box. 
	*	The path of the filename includes the file’s title plus the entire directory path. 
	*	For example, GetPathName will return "C:\FILES\TEXT.DAT" for the file "C:\FILES\TEXT.DAT".
	*/
	function GetPathName( $nFileID = NULL)
	{
		if( !isset( $this->strAnswer)) {
			return false;
		}

		if( $this->nFlags & OFN_ALLOWMULTISELECT) {
			return $this->strAnswer[ $nFileID];
		} else {
			return $this->strAnswer;
		}
	}//function GetPathName()


	/*
	*	Call this function to retrieve the name of the filename entered in the dialog box. 
	*	The name of the file includes both the prefix and the extension. 
	*	For example, GetFileName will return "TEXT.DAT" for the file "C:\FILES\TEXT.DAT".
	*/
	function GetFileName( $nFileID = NULL)
	{
		if( !isset( $this->strAnswer)) {
			return false;
		}

		if( $this->nFlags & OFN_ALLOWMULTISELECT) {
			return basename( $this->strAnswer[ $nFileID]);
		} else {
			return basename( $this->strAnswer);
		}
	}//function GetFileName()


	/*
	*	Call this function to retrieve the dir of the filename entered in the dialog box. 
	*	It includes the full directory path. 
	*	For example, GetFileName will return "C:\FILES" for the file "C:\FILES\TEXT.DAT".
	*/
	function GetFileDir( $nFileID = NULL)
	{
		if( !isset( $this->strAnswer)) {
			return false;
		}

		if( $this->nFlags & OFN_ALLOWMULTISELECT) {
			return dirname( $this->strAnswer[ $nFileID]);
		} else {
			return dirname( $this->strAnswer);
		}
	}//function GetFileDir()


	/*
	*	Call this function to retrieve the extension of the filename entered into the dialog box. 
	*	For example, if the name of the file entered is "DATA.TXT", GetFileExt returns "TXT".
	*/
	function GetFileExt( $nFileID = NULL)
	{
		if( !isset( $this->strAnswer)) {
			return false;
		}

		if( $this->nFlags & OFN_ALLOWMULTISELECT) {
			return $this->_GetFileExtension( $this->strAnswer[ $nFileID]);
		} else {
			return $this->_GetFileExtension( $this->strAnswer);
		}
	}//function GetFileExt()


	/*
	*	Call this function to retrieve the title of the file entered in the dialog box. 
	*	The title of the file includes only its prefix, without the path or the extension. 
	*	For example, GetFileTitle will return "TEXT" for the file "C:\FILES\TEXT.DAT".
	*/
	function GetFileTitle( $nFileID = NULL)
	{
		if( !isset( $this->strAnswer)) {
			return false;
		}
		
		if( $this->nFlags & OFN_ALLOWMULTISELECT) {
			$strFilename	= basename( $this->strAnswer[ $nFileID]);
		} else {
			$strFilename	= basename( $this->strAnswer);
		}

		$strExtension	= $this->_GetFileExtension( $this->strAnswer);
		$strTitle		= substr( $strFilename, 0, strlen( $strFilename) - strlen( $strExtension) - 1);
		
		return $strTitle;
	}//function GetFileTitle()



	/*
	*	Call this function to retrieve if the user has checked the "readonly" box
	*/
	function GetReadonly()
	{
		return $this->bReadonly;
	}//function GetReadonly()






	function _QuitDialog()
	{
		$this->_dlgFile->destroy();		
		GTK::main_quit();
	}//function _QuitDialog()


	function _OnButtonOK()
	{
		$strFilename	= $this->_dlgFile->get_filename();

		$strFilename	= $this->_RepairPath( $strFilename);
		if( strstr( PHP_OS, "WIN")) {
			$strFilename	= str_replace( "/", "\\", $strFilename);
		}

		//validate the string
		if( !($this->nFlags & OFN_NOVALIDATE)) 
		{
			if( strstr( PHP_OS, "WIN")) {
				if( !preg_match( "#^[a-zA-Z]{1}\:\\\\[^\*:\?\<\>\"]*$#", $strFilename)) {
					MessageBox( "You've typed an invalid name\n" . $strFilename, $this->strDialogTitle, MB_ICONEXCLAMATION);
					return false;
				}
			} else {
				if( !preg_match( "#^[^\*:\?\<\>\"]*$#", $strFilename)) {
					MessageBox( "You've typed an invalid name\n" . $strFilename, $this->strDialogTitle, MB_ICONEXCLAMATION);
					return false;
				}
			}			
		}


		if( $strFilename == "") {
			MessageBox( "Please select a file", $this->strDialogTitle, MB_ICONEXCLAMATION);
			return false;
		}

		//Add default extension?
		if( !($this->nFlags & OFN_SELECTDIR) && $this->strDefExt != "" && $this->_GetFileExtension( $strFilename) == "") {
			$strFilename		.= "." . $this->strDefExt;
		}

		//Dir changed and dirchange was not allowed?
		if( $this->nFlags & OFN_NOCHANGEDIR) {
			if( $this->strFileName === NULL || dirname( $this->strFileName) == "") {
				$strOriginalDir	= getcwd();
			} else {
				$strOriginalDir = dirname( $this->strFileName);
			}
			$nNewDir			= dirname( $strFilename);
			if( $nNewDir != $strOriginalDir) {
				strstr( PHP_OS, "WIN") ? $strPathSeparator = "\\" : $strPathSeparator = "/";
				$strFilename	= $strOriginalDir . $strPathSeparator . basename( $strFilename);
			}
		}

		//no valid path?
		if( $this->nFlags & OFN_PATHMUSTEXIST && !is_dir( dirname( $strFilename))) {
			MessageBox( "Please choose a file in an _existing_ directory!", $this->strDialogTitle, MB_ICONEXCLAMATION);
			return false;
		}
		//non-existing file?
		if( !($this->nFlags & OFN_SELECTDIR) && $this->nFlags & OFN_FILEMUSTEXIST && !file_exists( $strFilename)) {
			MessageBox( "Please choose an _existing_ file!", $this->strDialogTitle, MB_ICONEXCLAMATION);
			return false;
		}

		if( !($this->nFlags & OFN_SELECTDIR))
		{
			// Confirm overwriting when save file dialog
			if( !$this->bOpenFileDialog && file_exists( $strFilename) && $this->nFlags & OFN_OVERWRITEPROMPT) {
				$nOverwrite	= MessageBox( "Do you really want to overwrite the file\n" . $strFilename . "\n?", $this->strDialogTitle, MB_ICONQUESTION + MB_YESNO + MB_DEFBUTTON2);
				if( $nOverwrite == IDNO) {
					return false;
				}
			}
			//Confirm creation of new file
			if( $this->nFlags & OFN_CREATEPROMPT && !file_exists( $strFilename)) {
				$nCreate	= MessageBox( "Do you want to create the file\n" . $strFilename . "\n?", $this->strDialogTitle, MB_ICONQUESTION + MB_YESNO);
				if( $nCreate == IDNO) {
					return false;
				}
			}
		}
		//dirselection
		else 
		{
			//Confirm creation of new dir
			if( $this->nFlags & OFN_CREATEPROMPT && !is_dir( $strFilename)) {
				$nCreate	= MessageBox( "Do you want to create the dir\n" . $strFilename . "\n?", $this->strDialogTitle, MB_ICONQUESTION + MB_YESNO);
				if( $nCreate == IDNO) {
					return false;
				}
			}
		}

		
		//Readonly?
		if( !($this->nFlags & OFN_HIDEREADONLY)) {
			$this->bReadonly	= $this->_arWidgets["chkReadonly"]->get_active();
		} else {
			$this->bReadonly	= false;
		}

		$this->nButton		= IDOK;

		if( $this->nFlags & OFN_ALLOWMULTISELECT) {
			$this->strAnswer	= array( $strFilename);
			$strDir = dirname( $strFilename) . $this->strPathSeparator; 
			
			$nA = 0;
			while( isset( $this->_arWidgets["lstFiles"]->selection[$nA])) {
				$strFile = $strDir . $this->_arWidgets["lstFiles"]->get_text( $this->_arWidgets["lstFiles"]->selection[$nA], 0);
				if( array_search( $strFile, $this->strAnswer) === false) {
					array_push( $this->strAnswer, $strFile);
				}
				$nA++;
			}
		} else {
			$this->strAnswer	= $strFilename;
		}

		$this->_QuitDialog();
	}//function _OnButtonOK





	function _OnButtonCancel()
	{
		$this->strAnswer	= false;
		$this->nButton		= IDCANCEL;
		$this->_QuitDialog();
	}//function _OnButtonCancel


	function _OnButtonHelp()
	{
		if( $this->bOpenFileDialog) {
			$strParameter = "openfiledialog";
		} else {
			$strParameter = "savefiledialog";
		}
		
		if( $this->strHelpfunction == NULL) 
		{
			if( function_exists( "OnHelp")) {
				OnHelp( $strParameter);
			}
		} 
		else if( !is_array( $this->strHelpfunction)) 
		{
			if( function_exists( $this->strHelpfunction)) {
				$strFunction = $this->strHelpfunction;
				$strFunction( $strParameter);
			}
		}//no array and not NULL
		else 
		{
			if( is_object( $this->strHelpfunction[0]))
			{
				if( isset( $this->strHelpfunction[2])) {
					$strParameter	= $this->strHelpfunction[2];
				}
				$strFunction		= $this->strHelpfunction[1];
				$this->strHelpfunction[0]->$strFunction( $strParameter);
			}
			else
			{
				if( isset( $this->strHelpfunction[1])) {
					$strParameter	= $this->strHelpfunction[1];
				}
				$strFunction		= $this->strHelpfunction[0];
				$strFunction( $strParameter);
			}
		}//array
	}//function _OnButtonHelp()


	function _OnSelectFiletype( $mnuiItem, $strFilter)
	{
		if( $strFilter == "*") {
			$strFilter = "";
		}
		$this->_dlgFile		->complete( $strFilter);
	}//function _OnSelectFiletype( $mnuiItem, $strFilter)


	function _GetFileExtension( $strFilePath)
	{
		if( substr( $strFilePath, strlen( $strFilePath) - 1) != "/") {
			$nPos = strrpos( $strFilePath, ".");
			if( $nPos !== false) {
				return strtolower( substr( $strFilePath, $nPos + 1));
			} else {
				return "";
			}
		} else {
			return "";
		}
	}//function _GetFileExtension( $strFilePath)


	function _RepairPath( $strPath)
	{
		$strPath = str_replace( "\\", "/", $strPath);
		$strPath = preg_replace( "#/+#", "/", $strPath);
		$strOldPath = $strPath;
		while( true) {
			$strPath = preg_replace( "#/([^/\.]+[^/]*|[^/]*[^/\.]+[^/]*)/\.\./#", "/", $strPath);
			if( $strOldPath == $strPath) {
				break;
			}
			$strOldPath = $strPath;
		}
		return $strPath;
	}//function _RepairPath( $strPath)
}//class FileDialog

?>