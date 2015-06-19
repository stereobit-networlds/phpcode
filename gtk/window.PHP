<?php


    /* This if statement determines where is finds the appropriate file to run 
    * the gtk program.  It is for Windows and Linux (respectively) */ 
    if (!class_exists('gtk')) 
    { 
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') 
            dl('php_gtk.dll'); 
        else 
            dl('php_gtk.so'); 
    } 
     
    /* This function closes the window it is defaulted to false */ 
    function delete_event() 
    { 
        return false; 
    } 
     
    /* This is very important to actually destroying any instances 
     * of php running */ 
    function destroy() 
    { 
        Gtk::main_quit(); 
    } 
     
    /* This takes the instance of entry class and grabs what has been entered 
    * into the textbox and saves it to $gettext.  The instance of the label 
    * class is then set with the text saved from the $entry class */ 
    function set_name($label, $entry) 
    { 
        $gettext = $entry->get_text(); 
        $label->set_text($gettext); 
    } 

    /* Creation of the window */ 
    $window = &new GtkWindow(); 
    $window->set_name('main window'); 
    $window->set_title('Introduction to PHP-GTK'); 
    $window->set_usize(400, 300); 
    $window->connect('destroy', 'destroy'); 
    $window->connect('delete-event', 'delete_event'); 
    $window->set_border_width(10); 
    $window->set_position(GTK_WIN_POS_CENTER); 

    /* Creates the frame */ 
    $frame = &new GtkFrame('A Simple Update Program'); 
    $window->add($frame); 

    /* Creates the Vertical box for putting things in. */ 
    $box1 = &new GtkVBox(); 
    $frame->add($box1); 
    $box1->show(); 

    /* Creates the area where will be updating the information */ 
    $label = &new GtkLabel(''); 
    $box1->pack_start($label); 
    $label->show(); 

    /* Creates a horizontal line */ 
    $separator = &new GtkHSeparator(); 
    $box1->pack_start($separator); 
    $separator->show(); 

    /* Creates the textbox for the user to enter in the information */ 
    $entry = &new GtkEntry(); 
    $box1->pack_start($entry); 
    $entry->show(); 
     
    /* Creates the horizontal box for across the bottom of the window */ 
    $box2 = &new GtkHButtonBox(); 
    $box2->set_layout(GTK_BUTTONBOX_SPREAD); 
    $box1->add($box2); 
    $box1->show(); 
     
    /* Sets up one button that is in the button box */ 
    $button = &new GtkButton('Click to Update the Label'); 
    $button->connect_object('clicked', 'set_name', $label, $entry); 
    $box2->pack_start($button); 
    $button->show(); 
     
    /* Sets up the other button in the button box */ 
    $button = &new GtkButton('Close Window'); 
    $button->connect_object('clicked', 'destroy'); 
    $box2->pack_start($button); 
    $button->show(); 
     
    /* Closes off the frame by showing it */ 
    $frame->show(); 
     
    /* Tells the window to show all elements */ 
    $window->show_all(); 
     
    /* Finishes off the entire program */ 
    Gtk::main(); 


?>