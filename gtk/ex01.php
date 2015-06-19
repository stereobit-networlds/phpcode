<?php
/*
 * Tutorial Application.
 * Window construction from hello.php/php-gtk 0.5.0
 * This application will write a log string to file in a standard format
 * Then read the file, parse its contents and display each log entry on a line of a GTKCList
 */

if (!class_exists('gtk')) {
	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
		dl('php_gtk.dll');
	else
		dl('php_gtk.so');
}

/*
 * Called when the window is being destroyed. Simply quit the main loop.
 */
function destroy()
{
	Gtk::main_quit();
}

/*
 * Event handler to write log.
 */
function log_func()
{
	global	$window;
	$LogObj = new Log;
	$LogObj->LogFileName="testabc";
	$LogObj->OpenLog();
	$LogObj->WriteLog("This is a test log string");
	$LogObj->CloseLog();
}

/*
 * Event handler to read log and display it in a gtkclist.
 */

function read_func()
{
	global $window;
	$read_window = &new GtkWindow();
	$read_window->connect('destroy', 'destroy');
	$read_window->set_border_width(5);
	$titles = array("Date", "Source", "Severity", "Data");
	$readlist = &new GtkCList(4, $titles);
	$readlist->set_selection_mode(GTK_SELECTION_BROWSE);
	$ReadObj = new ReadLog;
	$ReadObj->LogFileName="testabc";
	$ReadObj->OpenLog();
	/*
	*  Loop through the entire log file, executing the ReadLog method until EOF.
	*/
	while (!feof ($ReadObj->LogFilePointer)) {
		$readlist->append($ReadObj->ReadLog());
	}
	//Set date column width to 150
	$readlist->set_column_width(0, 150);
	//Set source column width to 100
	$readlist->set_column_width(1, 100);
	$ReadObj->CloseLog();
	$read_scrolled_window = &new GtkScrolledWindow();
	$read_scrolled_window->set_policy(GTK_POLICY_AUTOMATIC, GTK_POLICY_AUTOMATIC);
	$read_scrolled_window->add_with_viewport($readlist);
	$read_window->add($read_scrolled_window);
	$read_window->set_usize(600, 200);
	$read_window->show_all();
}
/*
 * Create a new top-level window and connect the signals to the appropriate
 * functions. Note that all constructors must be assigned by reference.
 */
$window = &new GtkWindow();
$window->connect('destroy', 'destroy');
$window->set_border_width(10);

/*
 * Create a vertical layout box.
 */
$box = &new GtkVBox(false, 10);
$box->set_border_width(10);

/*
 * Create a button, connect its clicked event to log_func() and add
 * the button to the window.
 */
$button = &new GtkButton('Write Log');
$button->connect('clicked', 'log_func');

/*
 * Create a new tooltips object and use it to set a tooltip for the button.
 */
$tt = &new GtkTooltips();
$tt->set_delay(200);
$tt->set_tip($button, 'Writes Log');
$tt->enable();

/* Create a read button, add a tooltip for it and connect its clicked event to read_func() */
$read_button = &new GtkButton('Read Log');
$read_button->connect('clicked', 'read_func');
$tt->set_tip($read_button, 'Reads Log');

$box->pack_start($read_button);
$box->pack_start($button, false);

$window->add($box);
/*
 * Show the window and all its child widgets.
 */
$window->show_all();

/* Run the main loop. */
Gtk::main();


/* 
 * Log Writing Class 
 */
class Log {

	var $LogFileName;
	var $MaxFileLen;
	var $SourceName;
	var $Severity;
	var $LogFilePointer;

function Log() {
	/* Set default maximum file length to 1MB in bytes */
	$this->MaxFileLen=1048576;
	/* Set default source name to "Application" */
	$this->SourceName="Application";
	/* Set default severity to 0
	0 Denotes Information
    	1 Denotes Problem
    	2 Denotes Critical */
	$this->Severity=0;
}

function CloseLog() {
	fclose($this->LogFilePointer);
}

function OpenLog() {
	$LogFileNameFull="$this->LogFileName.txt";
	$this->LogFilePointer=fopen($LogFileNameFull, 'ab');
}

function WriteLog($LogData) {
	$CurrDate=date('d/m/Y h:i:s A');
	$LogString="$CurrDate , $this->SourceName , $this->Severity , $LogData\n";
	fwrite($this->LogFilePointer, $LogString);
}
}

/*
 * Log reading and parsing class
 */

class ReadLog {
	
	var $LogFileName;
	var $LogFilePointer;
	var $LogFileNameFull;
	
function OpenLog() {
	$this->LogFileNameFull="$this->LogFileName.txt";
	$this->LogFilePointer=fopen($this->LogFileNameFull, 'rb');
}

function CloseLog() {
	fclose($this->LogFilePointer);
}

function ReadLog() {
	$LogStr = explode(',', fgets($this->LogFilePointer), 4);
	$i=0;
	while ($i < 4) {
		if ($i == 3) { $LogStr[$i]= preg_replace("/\r\n|\n\r|\n|\r/", " ", $LogStr[$i]); }
		$LogFileArray[] = trim($LogStr[$i]);
		$i++;
	}
	return $LogFileArray;

}

}
	
?>