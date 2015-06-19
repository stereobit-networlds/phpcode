<?php

/*
   Copyright (C) 2003 Evan McNabb

   enmWebserver is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   enmWebserver is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   For a copy of the GNU General Public License go to http://www.gnu.org/licenses/gpl.html
   or write to:
         Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

echo "Starting enmWebserver...\n";

$address = '127.0.0.1';
$port = 3333;
$docroot = './docroot';
$phpcgipath = 'c:/webos/php';

/*  Be verbose when reporting errors */
error_reporting( E_ALL );

/*  Keep flushing all buffers so we can see what is coming in */
ob_implicit_flush();

/*  Create Socket */
if (($sock = socket_create( AF_INET, SOCK_STREAM, 0 )) < 0 )
{
    echo "socket_create() failed: reason: " . socket_strerror( $sock ) . "\n";
}

/*  Bind to Socket */
if (($ret = socket_bind( $sock, $address, $port )) < 0 )
{
    echo "socket_bind() failed: reason: " . socket_strerror( $ret ) . "\n";
}

/*  Listen on Socket */
if (($ret = socket_listen( $sock )) < 0 )
{
    echo "socket_listen() failed: reason: " . socket_strerror( $ret ) . "\n";
}

do
{

    /*  Accept incoming requests on Socket */
    if (($msgsock = socket_accept( $sock )) < 0 )
    {
        echo "socket_accept() failed: reason: " . socket_strerror( $msgsock ) . "\n";
        break;
    }

    /*  Send welcome message */
    //$msg = "Welcome...\n";
    //socket_write( $msgsock, $msg, strlen( $msg ));

    /*  Get message */
    do
    {
        /*  Read from Socket */
        if ( FALSE === ( $buf = socket_read( $msgsock, 1024 )))
        {
            echo "socket_read() failed: reason: " . socket_strerror( $buf ) . "\n";
            break 2;  /*  Break out of two loops */
        }

        /*  If we don't receive anything break out of the loop */
        if ( !$buf = trim( $buf ))
        {
            continue;
        }
    
        /*  Get the filename from the request */
        $request_info_array = get_request_info( $buf );
        print_r( $request_info_array ); //echo $webdir;
        $relative_filename = $request_info_array['filename'];
        $absolute_filename = /*getcwd()*/ $docroot . $request_info_array['filename'];

        /*  First see if it's there */
        if ( file_exists( $absolute_filename ))
        {
            echo "\nFile Exists...\n";

            /*  If it is a file we need to treat it differently */
            if ( is_dir( $absolute_filename ))
            {
                /*  Returns a string containing a page (either the index.html file or a page of file/dir links) */
                $page_string = get_directory_listing( $relative_filename );
                socket_write( $msgsock, $page_string, strlen( $page_string ) );
                break;
            }
            else
            {
                /*  It's a file; send it off */
                switch ( get_file_type( $relative_filename ) )
                {
				    case "htm" :
                    case "html":
                        //echo "HTML FILE!\n";

                        /*  Send message */
                        $message = get_header_message( '200-html', 0 );
                        socket_write( $msgsock, $message, strlen ( $message ) );

                        /*  Read the file into a string */
                        $file_string = file_get_contents( $absolute_filename );

                        /*  Now send it */
                        socket_write( $msgsock, $file_string, strlen( $file_string ) );
                        break 2;

                    case "jpg":
                        //echo "JPG FILE!\n";

                        /*  Read the file into a string */
                        $file_string = file_get_contents( $absolute_filename );
                        $file_size = strlen ( $file_string );

                        /*  Send message */
                        $message = get_header_message( '200-jpeg', $file_size );
                        socket_write( $msgsock, $message, $file_size );

                        /*  Send file */
                        socket_write( $msgsock, $file_string, $file_size );
                        break 2;

                    case "gif":
                        //echo "GIF FILE!\n";

                        /*  Read the file into a string */
                        $file_string = file_get_contents( $absolute_filename );
                        $file_size = strlen ( $file_string );

                        /*  Send message */
                        $message = get_header_message( '200-gif', $file_size );
                        socket_write( $msgsock, $message, $file_size );

                        /*  Send file */
                        socket_write( $msgsock, $file_string, $file_size );
                        break 2;

                    case "cgi":
                        //echo "CGI FILE!\n";
                        break 2;
						
                    case "php":
	                    $cmd = $phpcgipath."/php-cgi ".$absolute_filename;
                        $out = shell_exec($cmd);
						
                        socket_write( $msgsock, $out, strlen($out));						
                        break 2;						

                }
            }
            //socket_write ( $msgsock, $talkback, strlen ( $talkback ));
            
        }
        else 
        {
            //echo "\nFile Does Not Exist!!!\n";
            $message = get_header_message( '404', 0 );
            socket_write( $msgsock, $message , strlen ( $message ) );
            break;
        }


    } while ( true );
    socket_close( $msgsock );

} while ( true );
socket_close( $sock );

function get_request_info( $buf )
{
    /*  I can't think of a better way to do this right now, but it works */

    /*  Get request type (GET,POST,etc) */
    $tok = strtok( $buf, " " );
    $request_type = $tok;

    /*  Get filename */
        $tok = strtok(" \n\t");
    $filename = $tok;

    return array( 'request_type' => $request_type, 'filename' => $filename );
}

function get_file_type( $filename )
{
    /*  Once again, there is probably a better (less error prone) way to do this, but I can't think of it */

    if ( strstr( $filename, ".html" ) )
    {
        $type = "html";
    } elseif ( strstr( $filename, ".jpg" ) )
    {
        $type = "jpg";
    } elseif ( strstr( $filename, ".gif" ) )
    {
        $type = "gif";
    } elseif ( strstr( $filename, ".cgi" ) )
    {
        $type = "cgi";
    } else $type = "dirlisting";

    return $type;
}

function get_header_message( $type, $file_size )
{
    switch ( $type )
    {
        case "200-html":
            $message = "HTTP/1.0 200 OK\r\nContent-Type: text/html\r\n\r\n";
            break;
        case "200-jpeg":
            $message = "HTTP/1.0 200 OK\r\nContent-Type: image/jpeg\r\nContent-Length: $file_size\r\n\r\n";
            break;
        case "200-gif":
            $message = "HTTP/1.0 200 OK\r\nContent-Type: image/gif\r\nContent-Length: $file_size\r\n\r\n";
            break;
        case "404":
            $message = "HTTP/1.0 404 OK\r\nContent-Type: text/html\r\n\r\n<h1>404 Error: File Not Found!</h1>\r\n\r\n";
            break;
    }

    return $message;
}

function get_directory_listing( $relative_directory_name )
{
    /*  Get a directory listing:
        Either return a html page of links to every file and directories
        OR: return the index.html if it exists
    */

    global $address, $port, $docroot, $phpcgipath;
    $absolute_directory_name = /*getcwd()*/$docroot . $relative_directory_name;


    //$ls_output = `ls $absolute_directory_name`;
    //$ls_output_array = split( "\n", $ls_output );
	
    $ls_output_array = array();	
    $mydir = dir($absolute_directory_name);	
    while ($fileread = $mydir->read ()) {
	  if (($fileread!='.') && ($fileread!='..')) 
	    $ls_output_array[] = $fileread;  	
	}  

	if (count($ls_output_array)>1) {	
      $return_page_string = "<html><ul>\n";
      foreach ( $ls_output_array as $filename ) {
        if ( $filename == "index.html" )
        {
            $return_page_string = file_get_contents( $absolute_directory_name . "/index.html" );
            break;
        }    

        $return_page_string = $return_page_string . "<li><a href=\"http://$address:$port$relative_directory_name$filename\">$filename</a></li>\n";

      }
      $return_page_string = $return_page_string . "</ul></html>\n";
	}
	else {
	  //$inf = phpinfo();
	  //$return_page_string = "<html>".$inf."</html>\n";
	  
	  $cmd = $phpcgipath."/php-cgi ".$docroot."/phpinfo.php";
      $out = shell_exec($cmd);
      $return_page_string = $out;	  
	}
    
    return $return_page_string;
}

?>
