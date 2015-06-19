<?php

$__GTK['scintilla']['scintilla'] = 'Scintilla';
 

      @define(  "SCINTILLA_INVALID_POSITION"              ,   -1 ); 

      // GtkScintillaEolMode
      @define(  "SCINTILLA_EOL_CRLF"                      ,   0 ); 
      @define(  "SCINTILLA_EOL_CR"                        ,   1 ); 
      @define(  "SCINTILLA_EOL_LF"                        ,   2 ); 
      
      // GtkScintillaMarginType
      @define(  "SCINTILLA_MARGIN_SYMBOL"                 ,   0 ); 
      @define(  "SCINTILLA_MARGIN_NUMBER"                 ,   1 ); 
      
      // GtkScintillaEdgeMode
      @define(  "SCINTILLA_EDGE_NONE"                     ,   0 ); 
      @define(  "SCINTILLA_EDGE_LINE"                     ,   1 ); 
      @define(  "SCINTILLA_EDGE_BACKGROUND"               ,   2 ); 
      
      // Find flags
      @define(  "SCINTILLA_FIND_DOWN"                     ,   1 ); 
      @define(  "SCINTILLA_FIND_WHOLE_WORDS"              ,   2 ); 
      @define(  "SCINTILLA_FIND_MATCH_CASE"               ,   4 ); 
      @define(  "SCINTILLA_FIND_WORD_START"               ,   0x00100000 ); 
      @define(  "SCINTILLA_FIND_REGEXP"                   ,   0x00200000 ); 

      // GtkScintillaLexer
      @define(  "SCINTILLA_LEXER_CONTAINER"               ,   0 ); 
      @define(  "SCINTILLA_LEXER_NULL"                    ,   1 ); 
      @define(  "SCINTILLA_LEXER_PYTHON"                  ,   2 ); 
      @define(  "SCINTILLA_LEXER_CPP"                     ,   3 ); 
      @define(  "SCINTILLA_LEXER_HTML"                    ,   4 ); 
      @define(  "SCINTILLA_LEXER_XML"                     ,   5 ); 
      @define(  "SCINTILLA_LEXER_PERL"                    ,   6 ); 
      @define(  "SCINTILLA_LEXER_SQL"                     ,   7 ); 
      @define(  "SCINTILLA_LEXER_VB"                      ,   8 ); 
      @define(  "SCINTILLA_LEXER_PROPERTIES"              ,   9 ); 
      @define(  "SCINTILLA_LEXER_ERRORLIST"               ,   10 ); 
      @define(  "SCINTILLA_LEXER_MAKEFILE"                ,   11 ); 
      @define(  "SCINTILLA_LEXER_BATCH"                   ,   12 ); 
      @define(  "SCINTILLA_LEXER_XCODE"                   ,   13 ); 
      @define(  "SCINTILLA_LEXER_LATEX"                   ,   14 ); 
      @define(  "SCINTILLA_LEXER_LUA"                     ,   15 ); 
      @define(  "SCINTILLA_LEXER_DIFF"                    ,   16 ); 
      @define(  "SCINTILLA_LEXER_CONF"                    ,   17 ); 
      @define(  "SCINTILLA_LEXER_PASCAL"                  ,   18 ); 
      @define(  "SCINTILLA_LEXER_AVE"                     ,   19 ); 
      @define(  "SCINTILLA_LEXER_ADA"                     ,   20 ); 

      // GtkScintillaStyle
      @define(  "SCINTILLA_STYLE_DEFAULT"                 ,   32 ); 
      @define(  "SCINTILLA_STYLE_LINE_NUMBER"             ,   33 ); 
      @define(  "SCINTILLA_STYLE_BRACE_LIGHT"             ,   34 ); 
      @define(  "SCINTILLA_STYLE_BRACE_BAD"               ,   35 ); 
      @define(  "SCINTILLA_STYLE_CONTROL_CHAR"            ,   36 ); 
      @define(  "SCINTILLA_STYLE_INDENT_GUIDE"            ,   37 ); 
      @define(  "SCINTILLA_STYLE_MAX"                     ,   127 ); 

      // LEXER_PYTHON lexical states
      @define(  "SCINTILLA_PYTHON_WHITE_SPACE"            ,   0 ); 
      @define(  "SCINTILLA_PYTHON_COMMENT_LINE"           ,   1 ); 
      @define(  "SCINTILLA_PYTHON_NUMBER"                 ,   2 ); 
      @define(  "SCINTILLA_PYTHON_STRING_DOUBLE"          ,   3 ); 
      @define(  "SCINTILLA_PYTHON_STRING_SINGLE"          ,   4 ); 
      @define(  "SCINTILLA_PYTHON_KEYWORD"                ,   5 ); 
      @define(  "SCINTILLA_PYTHON_TRIPLE_SINGLE"          ,   6 ); 
      @define(  "SCINTILLA_PYTHON_TRIPLE_DOUBLE"          ,   7 ); 
      @define(  "SCINTILLA_PYTHON_CLASS_STATEMENT"        ,   8 ); 
      @define(  "SCINTILLA_PYTHON_DEF_STATEMENT"          ,   9 ); 
      @define(  "SCINTILLA_PYTHON_OPERATOR"               ,   10 ); 
      @define(  "SCINTILLA_PYTHON_IDENTIFIER"             ,   11 ); 
      @define(  "SCINTILLA_PYTHON_COMMENT_BLOCK"          ,   12 ); 
      @define(  "SCINTILLA_PYTHON_STRING_EOL"             ,   13 ); 
      
      // LEXER_CPP Lexical states
      @define(  "SCINTILLA_CPP_WHITE_SPACE"               ,   0 ); 
      @define(  "SCINTILLA_CPP_COMMENT_BLOCK"             ,   1 ); 
      @define(  "SCINTILLA_CPP_COMMENT_LINE"              ,   2 ); 
      @define(  "SCINTILLA_CPP_COMMENT_DOC"               ,   3 ); 
      @define(  "SCINTILLA_CPP_NUMBER"                    ,   4 ); 
      @define(  "SCINTILLA_CPP_KEYWORD"                   ,   5 ); 
      @define(  "SCINTILLA_CPP_STRING"                    ,   6 ); 
      @define(  "SCINTILLA_CPP_CHARACTER"                 ,   7 ); 
      @define(  "SCINTILLA_CPP_UUID"                      ,   8 ); 
      @define(  "SCINTILLA_CPP_PREPROCESSOR"              ,   9 ); 
      @define(  "SCINTILLA_CPP_OPERATOR"                  ,   10 ); 
      @define(  "SCINTILLA_CPP_IDENTIFIER"                ,   11 ); 
      @define(  "SCINTILLA_CPP_STRING_EOL"                ,   12 ); 
      @define(  "SCINTILLA_CPP_STRING_VERBATIM"           ,   13 ); 
      @define(  "SCINTILLA_CPP_REGEX"                     ,   14 ); 
      @define(  "SCINTILLA_CPP_COMMENT_LINE_DOC"          ,   15 ); 
      @define(  "SCINTILLA_CPP_WORD2"                     ,   16 ); 
      @define(  "SCINTILLA_CPP_COMMENT_DOC_KEYWORD"       ,   17 ); 
      @define(  "SCINTILLA_CPP_COMMENT_DOC_KEYWORD_ERROR" ,   18 ); 
      
      
      // LEXER_HTML Lexical states
      @define(  "SCINTILLA_HTML_TEXT"                     ,   0 ); 
      @define(  "SCINTILLA_HTML_TAG"                      ,   1 ); 
      @define(  "SCINTILLA_HTML_TAG_UNKNOWN"              ,   2 ); 
      @define(  "SCINTILLA_HTML_ATTRIBUTE"                ,   3 ); 
      @define(  "SCINTILLA_HTML_ATTRIBUTE_UNKNOWN"        ,   4 ); 
      @define(  "SCINTILLA_HTML_NUMBER"                   ,   5 ); 
      @define(  "SCINTILLA_HTML_DOUBLE_STRING"            ,   6 ); 
      @define(  "SCINTILLA_HTML_SINGLE_STRING"            ,   7 ); 
      @define(  "SCINTILLA_HTML_OTHER"                    ,   8 ); 
      @define(  "SCINTILLA_HTML_COMMENT"                  ,   9 ); 
      @define(  "SCINTILLA_HTML_ENTITY"                   ,   10 ); 
      @define(  "SCINTILLA_HTML_XML_TAG_END"              ,   11    ); 
      @define(  "SCINTILLA_HTML_XML_ID_START"             ,   12    ); 
      @define(  "SCINTILLA_HTML_XML_ID_END"               ,   13    ); 
      @define(  "SCINTILLA_HTML_SCRIPT"                   ,   14 ); 
      @define(  "SCINTILLA_HTML_ASP_1"                    ,   15  ); 
      @define(  "SCINTILLA_HTML_ASP_2"                    ,   16   ); 
      @define(  "SCINTILLA_HTML_CDATA"                    ,   17 ); 
      @define(  "SCINTILLA_HTML_PHP"                      ,   18 ); 
      @define(  "SCINTILLA_HTML_UNQUOTED"                 ,   19 ); 
      
      // LEXER HTML :: Embedded Javascript
      @define(  "SCINTILLA_HTML_JS_START"                 ,   40 ); 
      @define(  "SCINTILLA_HTML_JS_DEFAULT"               ,   41 ); 
      @define(  "SCINTILLA_HTML_JS_COMMENT_BLOCK"         ,   42 ); 
      @define(  "SCINTILLA_HTML_JS_COMMENT_LINE"          ,   43 ); 
      @define(  "SCINTILLA_HTML_JS_COMMENT_DOC"           ,   44 ); 
      @define(  "SCINTILLA_HTML_JS_NUMBER"                ,   45 ); 
      @define(  "SCINTILLA_HTML_JS_WORD"                  ,   46 ); 
      @define(  "SCINTILLA_HTML_JS_KEYWORD"               ,   47 ); 
      @define(  "SCINTILLA_HTML_JS_STRING_DOUBLE"         ,   48 ); 
      @define(  "SCINTILLA_HTML_JS_STRING_SINGLE"         ,   49 ); 
      @define(  "SCINTILLA_HTML_JS_SYMBOL"                ,   50 ); 
      @define(  "SCINTILLA_HTML_JS_EOL"                   ,   51 ); 
      @define(  "SCINTILLA_HTML_JS_REGEX"                 ,   52 ); 
      
      // LEXER_HTML :: ASP Javascript
      @define(  "SCINTILLA_HTML_ASPJS_START"              ,   55 ); 
      @define(  "SCINTILLA_HTML_ASPJS_DEFAULT"            ,   56 ); 
      @define(  "SCINTILLA_HTML_ASPJS_COMMENT_BLOCK"      ,   57 ); 
      @define(  "SCINTILLA_HTML_ASPJS_COMMENT_LINE"       ,   58 ); 
      @define(  "SCINTILLA_HTML_ASPJS_COMMENT_DOC"        ,   59 ); 
      @define(  "SCINTILLA_HTML_ASPJS_NUMBER"             ,   60 ); 
      @define(  "SCINTILLA_HTML_ASPJS_WORD"               ,   61 ); 
      @define(  "SCINTILLA_HTML_ASPJS_KEYWORD"            ,   62 ); 
      @define(  "SCINTILLA_HTML_ASPJS_STRING_DOUBLE"      ,   63 ); 
      @define(  "SCINTILLA_HTML_ASPJS_STRING_SINGLE"      ,   64 ); 
      @define(  "SCINTILLA_HTML_ASPJS_SYMBOL"             ,   65 ); 
      @define(  "SCINTILLA_HTML_ASPJS_EOL"                ,   66 ); 
      @define(  "SCINTILLA_HTML_ASPJS_REGEX"              ,   67 ); 
      
      // LEXER_HTML :: Embedded VBS
      @define(  "SCINTILLA_HTML_VBS_START"                ,   70 ); 
      @define(  "SCINTILLA_HTML_VBS_DEFAULT"              ,   71 ); 
      @define(  "SCINTILLA_HTML_VBS_COMMENT"              ,   72 ); 
      @define(  "SCINTILLA_HTML_VBS_NUMBER"               ,   73 ); 
      @define(  "SCINTILLA_HTML_VBS_KEYWORD"              ,   74 ); 
      @define(  "SCINTILLA_HTML_VBS_STRING"               ,   75 ); 
      @define(  "SCINTILLA_HTML_VBS_IDENTIFIER"           ,   76 ); 
      @define(  "SCINTILLA_HTML_VBS_EOL"                  ,   77 ); 
      
      // LEXER_HTML :: ASP VBS
      @define(  "SCINTILLA_HTML_ASPVBS_START"             ,   80 ); 
      @define(  "SCINTILLA_HTML_ASPVBS_DEFAULT"           ,   81 ); 
      @define(  "SCINTILLA_HTML_ASPVBS_COMMENT"           ,   82 ); 
      @define(  "SCINTILLA_HTML_ASPVBS_NUMBER"            ,   83 ); 
      @define(  "SCINTILLA_HTML_ASPVBS_KEYWORD"           ,   84 ); 
      @define(  "SCINTILLA_HTML_ASPVBS_STRING"            ,   85 ); 
      @define(  "SCINTILLA_HTML_ASPVBS_IDENTIFIER"        ,   86 ); 
      @define(  "SCINTILLA_HTML_ASPVBS_EOL"               ,   87 ); 
      
      // LEXER_HTML :: Embedded Python
      @define(  "SCINTILLA_HTML_PY_START"                 ,   90 ); 
      @define(  "SCINTILLA_HTML_PY_DEFAULT"               ,   91 ); 
      @define(  "SCINTILLA_HTML_PY_COMMENT_LINE"          ,   92 ); 
      @define(  "SCINTILLA_HTML_PY_NUMBER"                ,   93 ); 
      @define(  "SCINTILLA_HTML_PY_STRING_DOUBLE"         ,   94 ); 
      @define(  "SCINTILLA_HTML_PY_STRING_SINGLE"         ,   95 ); 
      @define(  "SCINTILLA_HTML_PY_KEYWORD"               ,   96 ); 
      @define(  "SCINTILLA_HTML_PY_TRIPLE_SINGLE"         ,   97 ); 
      @define(  "SCINTILLA_HTML_PY_TRIPLE_DOUBLE"         ,   98 ); 
      @define(  "SCINTILLA_HTML_PY_CLASS_STATEMENT"       ,   99 ); 
      @define(  "SCINTILLA_HTML_PY_DEF_STATEMENT"         ,   100 ); 
      @define(  "SCINTILLA_HTML_PY_OPERATOR"              ,   101 ); 
      @define(  "SCINTILLA_HTML_PY_IDENTIFIER"            ,   102 ); 
      
      // LEXER_HTML :: ASP Python
      @define(  "SCINTILLA_HTML_ASPPY_START"              ,   105 ); 
      @define(  "SCINTILLA_HTML_ASPPY_DEFAULT"            ,   106 ); 
      @define(  "SCINTILLA_HTML_ASPPY_COMMENT_LINE"       ,   107 ); 
      @define(  "SCINTILLA_HTML_ASPPY_NUMBER"             ,   108 ); 
      @define(  "SCINTILLA_HTML_ASPPY_STRING_DOUBLE"      ,   109 ); 
      @define(  "SCINTILLA_HTML_ASPPY_STRING_SINGLE"      ,   110 ); 
      @define(  "SCINTILLA_HTML_ASPPY_KEYWORD"            ,   111 ); 
      @define(  "SCINTILLA_HTML_ASPPY_TRIPLE_SINGLE"      ,   112 ); 
      @define(  "SCINTILLA_HTML_ASPPY_TRIPLE_DOUBLE"      ,   113 ); 
      @define(  "SCINTILLA_HTML_ASPPY_CLASS_STATEMENT"    ,   114 ); 
      @define(  "SCINTILLA_HTML_ASPPY_DEF_STATEMENT"      ,   115 ); 
      @define(  "SCINTILLA_HTML_ASPPY_OPERATOR"           ,   116 ); 
      @define(  "SCINTILLA_HTML_ASPPY_IDENTIFIER"         ,   117 ); 
      
      // LEXER_HTML :: PHP
      @define(  "SCINTILLA_HTML_PHP_DEFAULT"              ,   118 ); 
      @define(  "SCINTILLA_HTML_PHP_STRING_DOUBLE"        ,   119 ); 
      @define(  "SCINTILLA_HTML_PHP_STRING_SINGLE"        ,   120 ); 
      @define(  "SCINTILLA_HTML_PHP_KEYWORD"              ,   121 ); 
      @define(  "SCINTILLA_HTML_PHP_NUMBER"               ,   122 ); 
      @define(  "SCINTILLA_HTML_PHP_VARIABLE"             ,   123 ); 
      @define(  "SCINTILLA_HTML_PHP_COMMENT_BLOCK"        ,   124 ); 
      @define(  "SCINTILLA_HTML_PHP_COMMENT_LINE"         ,   125 ); 
      @define(  "SCINTILLA_HTML_PHP_EOL"                  ,   126 ); 
      @define(  "SCINTILLA_HTML_PHP_OPERATOR"             ,   127 ); 
      
      // LEXER_XML Lexical states
      @define(  "SCINTILLA_XML_DEFAULT"                   ,   0 ); 
      @define(  "SCINTILLA_XML_TAG"                       ,   1 ); 
      @define(  "SCINTILLA_XML_TAG_UNKNOWN"               ,   2 ); 
      @define(  "SCINTILLA_XML_ATTRIBUTE"                 ,   3 ); 
      @define(  "SCINTILLA_XML_ATTRIBUTE_UNKNOWN"         ,   4 ); 
      @define(  "SCINTILLA_XML_NUMBER"                    ,   5 ); 
      @define(  "SCINTILLA_XML_DOUBLE_STRING"             ,   6 ); 
      @define(  "SCINTILLA_XML_SINGLE_STRING"             ,   7 ); 
      @define(  "SCINTILLA_XML_OTHER"                     ,   8 ); 
      @define(  "SCINTILLA_XML_COMMENT"                   ,   9 ); 
      @define(  "SCINTILLA_XML_ENTITY"                    ,   10 ); 
      @define(  "SCINTILLA_XML_TAG_END"                   ,   11 ); 
      @define(  "SCINTILLA_XML_ID_START"                  ,   12 ); 
      @define(  "SCINTILLA_XML_ID_END"                    ,   13 ); 
      @define(  "SCINTILLA_XML_CDATA"                     ,   17 ); 
      @define(  "SCINTILLA_XML_QUESTION"                  ,   18 ); 
      @define(  "SCINTILLA_XML_UNQUOTED"                  ,   19 ); 
      
      // LEXER_PERL Lexical states
      @define(  "SCINTILLA_PERL_WHITE_SPACE"              ,   0 ); 
      @define(  "SCINTILLA_PERL_ERROR"                    ,   1 ); 
      @define(  "SCINTILLA_PERL_COMMENT_LINE"             ,   2 ); 
      @define(  "SCINTILLA_PERL_POD"                      ,   3 ); 
      @define(  "SCINTILLA_PERL_NUMBER"                   ,   4 ); 
      @define(  "SCINTILLA_PERL_KEYWORD"                  ,   5 ); 
      @define(  "SCINTILLA_PERL_STRING"                   ,   6 ); 
      @define(  "SCINTILLA_PERL_CHARACTER"                ,   7 ); 
      @define(  "SCINTILLA_PERL_PUNCTUATION"              ,   8 ); 
      @define(  "SCINTILLA_PERL_PREPROCESSOR"             ,   9 ); 
      @define(  "SCINTILLA_PERL_OPERATOR"                 ,   10 ); 
      @define(  "SCINTILLA_PERL_IDENTIFIER"               ,   11 ); 
      @define(  "SCINTILLA_PERL_SCALAR"                   ,   12 ); 
      @define(  "SCINTILLA_PERL_ARRAY"                    ,   13 ); 
      @define(  "SCINTILLA_PERL_HASH"                     ,   14 ); 
      @define(  "SCINTILLA_PERL_SYMBOL_TABLE"             ,   15 ); 
      @define(  "SCINTILLA_PERL_REGEX"                    ,   17 ); 
      @define(  "SCINTILLA_PERL_REGSUBST"                 ,   18 ); 
      @define(  "SCINTILLA_PERL_LONG_QUOTE"               ,   19 ); 
      @define(  "SCINTILLA_PERL_BACKTICKS"                ,   20 ); 
      @define(  "SCINTILLA_PERL_DATA_SECTION"             ,   21 ); 
      @define(  "SCINTILLA_PERL_HERE_DELIM"               ,   22 ); 
      @define(  "SCINTILLA_PERL_HERE_Q"                   ,   23 ); 
      @define(  "SCINTILLA_PERL_HERE_QQ"                  ,   24 ); 
      @define(  "SCINTILLA_PERL_HERE_QX"                  ,   25 ); 
      @define(  "SCINTILLA_PERL_STRING_Q"                 ,   26 ); 
      @define(  "SCINTILLA_PERL_STRING_QQ"                ,   27 ); 
      @define(  "SCINTILLA_PERL_STRING_QX"                ,   28 ); 
      @define(  "SCINTILLA_PERL_STRING_QR"                ,   29 ); 
      @define(  "SCINTILLA_PERL_STRING_QW"                ,   30 ); 
      
      // LEXER_SQL Lexical states
      @define(  "SCINTILLA_SQL_WHITE_SPACE"               ,   0 ); 
      @define(  "SCINTILLA_SQL_COMMENT_BLOCK"             ,   1 ); 
      @define(  "SCINTILLA_SQL_COMMENT_LINE"              ,   2 ); 
      @define(  "SCINTILLA_SQL_COMMENT_DOC"               ,   3 ); 
      @define(  "SCINTILLA_SQL_NUMBER"                    ,   4 ); 
      @define(  "SCINTILLA_SQL_KEYWORD"                   ,   5 ); 
      @define(  "SCINTILLA_SQL_DOUBLE_STRING"             ,   6 ); 
      @define(  "SCINTILLA_SQL_SINGLE_STRING"             ,   7 ); 
      @define(  "SCINTILLA_SQL_SYMBOLS"                   ,   8 ); 
      @define(  "SCINTILLA_SQL_PREPROCESSOR"              ,   9 ); 
      @define(  "SCINTILLA_SQL_OPERATOR"                  ,   10 ); 
      @define(  "SCINTILLA_SQL_IDENTIFIER"                ,   11 ); 
      @define(  "SCINTILLA_SQL_STRING_EOL"                ,   12 ); 
      
      // LEXER_VB Lexical states
      @define(  "SCINTILLA_VB_WHITE_SPACE"                ,   0 ); 
      @define(  "SCINTILLA_VB_COMMENT_BLOCK"              ,   1 ); 
      @define(  "SCINTILLA_VB_COMMENT_LINE"               ,   2 ); 
      @define(  "SCINTILLA_VB_COMMENT_DOC"                ,   3 ); 
      @define(  "SCINTILLA_VB_NUMBER"                     ,   4 ); 
      @define(  "SCINTILLA_VB_WORD"                       ,   5 ); 
      @define(  "SCINTILLA_VB_STRING"                     ,   6 ); 
      @define(  "SCINTILLA_VB_CHARACTER"                  ,   7 ); 
      @define(  "SCINTILLA_VB_UUID"                       ,   8 ); 
      @define(  "SCINTILLA_VB_PREPROCESSOR"               ,   9 ); 
      @define(  "SCINTILLA_VB_OPERATOR"                   ,   10 ); 
      @define(  "SCINTILLA_VB_IDENTIFIER"                 ,   11 ); 
      @define(  "SCINTILLA_VB_STRING_EOL"                 ,   12 ); 
      
      // LEXER_PROPERTIES Lexical states
      @define(  "SCINTILLA_PROPERTIES_DEFAULT"            ,   0 ); 
      @define(  "SCINTILLA_PROPERTIES_COMMENT"            ,   1 ); 
      @define(  "SCINTILLA_PROPERTIES_SECTION"            ,   2 ); 
      @define(  "SCINTILLA_PROPERTIES_OPERATOR"           ,   3 ); 
      @define(  "SCINTILLA_PROPERTIES_DEFAULT_VAL"        ,   4 ); 
      
      // LEXER_ERRORLIST Lexical states
      @define(  "SCINTILLA_ERROR_DEFAULT"                 ,   0 ); 
      @define(  "SCINTILLA_ERROR_PYTHON"                  ,   1 ); 
      @define(  "SCINTILLA_ERROR_GCC"                     ,   2 ); 
      @define(  "SCINTILLA_ERROR_MS"                      ,   3 ); 
      @define(  "SCINTILLA_ERROR_CMD"                     ,   4 ); 
      @define(  "SCINTILLA_ERROR_BORLAND"                 ,   5 ); 
      @define(  "SCINTILLA_ERROR_PERL"                    ,   6 ); 
      @define(  "SCINTILLA_ERROR_DIFF_CHANGED"            ,   10 ); 
      @define(  "SCINTILLA_ERROR_DIFF_ADDITION"           ,   11 ); 
      @define(  "SCINTILLA_ERROR_DIFF_DELETION"           ,   12 ); 
      @define(  "SCINTILLA_ERROR_DIFF_MESSAGE"            ,   13 ); 
      
      // LEXER_MAKEFILE Lexical states
      @define(  "SCINTILLA_MAKEFILE_WHITE_SPACE"          ,   0 ); 
      @define(  "SCINTILLA_MAKEFILE_COMMENT"              ,   1 ); 
      @define(  "SCINTILLA_MAKEFILE_PREPROCESSOR"         ,   2 ); 
      @define(  "SCINTILLA_MAKEFILE_IDENTIFIER"           ,   3 ); 
      @define(  "SCINTILLA_MAKEFILE_OPERATOR"             ,   4 ); 
      @define(  "SCINTILLA_MAKEFILE_IDEOL"                ,   9 ); 
      
      // LEXER_BATCH Lexical states
      @define(  "SCINTILLA_BATCH_DEFAULT"                 ,   0 ); 
      @define(  "SCINTILLA_BATCH_COMMENT"                 ,   1 ); 
      @define(  "SCINTILLA_BATCH_WORD"                    ,   2 ); 
      @define(  "SCINTILLA_BATCH_LABEL"                   ,   3 ); 
      @define(  "SCINTILLA_BATCH_HIDE"                    ,   4 ); 
      @define(  "SCINTILLA_BATCH_COMMAND"                 ,   5 ); 
      @define(  "SCINTILLA_BATCH_IDENTIFIER"              ,   6 ); 
      @define(  "SCINTILLA_BATCH_OPERATOR"                ,   7 ); 
      
      // LEXER_LATEX Lexical states
      @define(  "SCINTILLA_LATEX_WHITE_SPACE"             ,   0 ); 
      @define(  "SCINTILLA_LATEX_COMMAND"                 ,   1 ); 
      @define(  "SCINTILLA_LATEX_TAG"                     ,   2 ); 
      @define(  "SCINTILLA_LATEX_MATH"                    ,   3 ); 
      @define(  "SCINTILLA_LATEX_COMMENT"                 ,   4 ); 
      
      // LEXER_LUA Lexical states
      @define(  "SCINTILLA_LUA_WHITE_SPACE"               ,   0 ); 
      @define(  "SCINTILLA_LUA_COMMENT_BLOCK"             ,   1 ); 
      @define(  "SCINTILLA_LUA_COMMENT_LINE"              ,   2 ); 
      @define(  "SCINTILLA_LUA_COMMENT_DOC"               ,   3 ); 
      @define(  "SCINTILLA_LUA_NUMBER"                    ,   4 ); 
      @define(  "SCINTILLA_LUA_KEYWORD"                   ,   5 ); 
      @define(  "SCINTILLA_LUA_STRING"                    ,   6 ); 
      @define(  "SCINTILLA_LUA_CHARACTER"                 ,   7 ); 
      @define(  "SCINTILLA_LUA_LITERAL_STRING"            ,   8 ); 
      @define(  "SCINTILLA_LUA_PREPROCESSOR"              ,   9 ); 
      @define(  "SCINTILLA_LUA_OPERATOR"                  ,   10 ); 
      @define(  "SCINTILLA_LUA_IDENTIFIER"                ,   11 ); 
      @define(  "SCINTILLA_LUA_STRING_EOL"                ,   12 ); 
      
      // LEXER_DIFF Lexical states
      @define(  "SCINTILLA_DIFF_DEFAULT"                  ,   0 ); 
      @define(  "SCINTILLA_DIFF_COMMENT"                  ,   1 ); 
      @define(  "SCINTILLA_DIFF_COMMAND"                  ,   2 ); 
      @define(  "SCINTILLA_DIFF_FILES"                    ,   3 ); 
      @define(  "SCINTILLA_DIFF_POSITION"                 ,   4 ); 
      @define(  "SCINTILLA_DIFF_DEL_LINE"                 ,   5 ); 
      @define(  "SCINTILLA_DIFF_ADD_LINE"                 ,   6 ); 
      
      // LEXER_CONF Lexical states
      @define(  "SCINTILLA_CONF_DEFAULT"                  ,   0 ); 
      @define(  "SCINTILLA_CONF_COMMENT"                  ,   1 ); 
      @define(  "SCINTILLA_CONF_NUMBER"                   ,   2 ); 
      @define(  "SCINTILLA_CONF_IDENTIFIER"               ,   3 ); 
      @define(  "SCINTILLA_CONF_EXTENSION"                ,   4 ); 
      @define(  "SCINTILLA_CONF_PARAMETER"                ,   5 ); 
      @define(  "SCINTILLA_CONF_STRING"                   ,   6 ); 
      @define(  "SCINTILLA_CONF_OPERATOR"                 ,   7 ); 
      @define(  "SCINTILLA_CONF_IP"                       ,   8 ); 
      @define(  "SCINTILLA_CONF_DIRECTIVE"                ,   9 ); 
      
      // LEXER_PASCAL Lexical states
      @define(  "SCINTILLA_PASCAL_WHITE_SPACE"            ,   0 ); 
      @define(  "SCINTILLA_PASCAL_COMMENT_BLOCK"          ,   1 ); 
      @define(  "SCINTILLA_PASCAL_COMMENT_LINE"           ,   2 ); 
      @define(  "SCINTILLA_PASCAL_COMMENT_DOC"            ,   3 ); 
      @define(  "SCINTILLA_PASCAL_NUMBER"                 ,   4 ); 
      @define(  "SCINTILLA_PASCAL_KEYWORD"                ,   5 ); 
      @define(  "SCINTILLA_PASCAL_DOUBLE_STRING"          ,   6 ); 
      @define(  "SCINTILLA_PASCAL_SINGLE_STRING"          ,   7 ); 
      @define(  "SCINTILLA_PASCAL_SYMBOLS"                ,   8 ); 
      @define(  "SCINTILLA_PASCAL_PREPROCESSOR"           ,   9 ); 
      
      // LEXER_AVE Lexical states
      @define(  "SCINTILLA_AVE_DEFAULT"                   ,   0 ); 
      @define(  "SCINTILLA_AVE_COMMENT"                   ,   1 ); 
      @define(  "SCINTILLA_AVE_NUMBER"                    ,   2 ); 
      @define(  "SCINTILLA_AVE_WORD"                      ,   3 ); 
      @define(  "SCINTILLA_AVE_KEYWORD"                   ,   4 ); 
      @define(  "SCINTILLA_AVE_STATEMENT"                 ,   5 ); 
      @define(  "SCINTILLA_AVE_STRING"                    ,   6 ); 
      @define(  "SCINTILLA_AVE_ENUM"                      ,   7 ); 
      @define(  "SCINTILLA_AVE_STRINGEOL"                 ,   8 ); 
      @define(  "SCINTILLA_AVE_IDENTIFIER"                ,   9 ); 
      @define(  "SCINTILLA_AVE_OPERATOR"                  ,   10 ); 
      
      // LEXER_ADA Lexical states
      @define(  "SCINTILLA_ADA_DEFAULT"                   ,   0 ); 
      @define(  "SCINTILLA_ADA_COMMENT"                   ,   1 ); 
      @define(  "SCINTILLA_ADA_NUMBER"                    ,   2 ); 
      @define(  "SCINTILLA_ADA_WORD"                      ,   3 ); 
      @define(  "SCINTILLA_ADA_STRING"                    ,   4 ); 
      @define(  "SCINTILLA_ADA_CHARACTER"                 ,   5 ); 
      @define(  "SCINTILLA_ADA_OPERATOR"                  ,   6 ); 
      @define(  "SCINTILLA_ADA_IDENTIFIER"                ,   7 ); 
      @define(  "SCINTILLA_ADA_STRINGEOL"                 ,   8 ); 	  

class scintilla  {

    var $con;
	var $changed_flag;
	var $scintilla; 
	
	var $curpos;
	
	function scintilla($container=null) {	
	
      //dl('php_gtk_scintilla.' . (strstr(PHP_OS, 'WIN') ? 'dll' : 'so'));
	
	  if ($container!=null) $this->scintilla_control($container);  
	  
	  $this->changed_flag = false;	  
	}	
	
	function scintilla_control(&$container) {	
	
	  $mainbox = &new GtkVBox(false, 5);
	  $container->add($mainbox);  	
	
	  //holds scintilla menu
	  $hbox = &new GtkVBox(false, 5);
	  $hbox->set_border_width(0);
	  $mainbox->pack_start($hbox, false);	
	
      $this->scibar = &new GtkMenuBar();
	  $hbox->pack_start($this->scibar, false, false, 0); 
	  $this->menu($this->scibar);	
	  
	  //holds scintilla itself
	  $vbox = &new GtkVBox(true, 0);
	  $vbox->set_border_width(0);
	  $mainbox->pack_start($vbox, true);
	
	  $this->scintilla = &new GtkScintilla();
      $vbox->add($this->scintilla);
	  //$container->add($this->scintilla);
	  
      //$this->scintilla->add_events(GDK_BUTTON_PRESS_MASK);
	  
	  
	  //SCINTILLA CONNECTIONS
      $this->scintilla->connect('char_added',array(&$this,'text_changed'));	

      $this->scintilla->connect_object('update_ui', array(&$this,'highlight_braces'));
      $this->scintilla->connect_object('uri_dropped', array(&$this->scintilla,'uri_dropped'));
      //$this->scintilla->connect_object('margin_click', array(&$this,'margin_click'));
      //$this->scintilla->connect_object('button-press-event', array(&$this,'popup_check'));
	    
	  
	  //SCINTILLA ATTRIBUTES
	  ///////////////////////////////////////////////////////////////
	  $this->scintilla->grab_focus();
        
	  //$this->scintilla->set_caret_line_visible(1);//shows line color
	  //$this->scintilla->->set_indentation_guides(1);
	  
	  $this->scintilla->colourise(0,-1);//????
	  
      $this->scintilla->set_lexer(7);
	  //$this->scintilla->set_lexer_language(SCINTILLA_LEXER_CSS);	
      $this->scintilla->set_lexer(SCINTILLA_LEXER_HTML*1);	    
	  
      $this->scintilla->set_style_bits(5);
      //$this->scintilla->set_style_bits(7);	
	  //$this->scintilla->style_set_fore(33,505050); //for color of numbering
	  //$this->scintilla->style_set_back(33,100);	 //back color of numbering 
	  
	  $this->scintilla->set_code_page(65001);  	  
      //$this->scintilla->style_set_font(32,"-*-tahoma-medium-r-normal--14-*-*-*-*-*-windows-1252");	  
	  
	  $this->scintilla->selection_is_rectangle();
	  $this->scintilla->set_keywords(0, "test");
      $this->scintilla->set_tab_width(3);	    
	  
	  //$this->scintilla->set_view_eol(1); //view cr/lf marks at end of line
	  //$this->scintilla->set_eol_mode(0); //change eol mode for unix/win files		
	  
      $this->scintilla->style_set_font(SCINTILLA_STYLE_BRACE_LIGHT, '-*-*-bold-*-*-*-*-*-*-*-*-*-*-*');
      $this->scintilla->style_set_fore(SCINTILLA_STYLE_BRACE_LIGHT, 1);
      $this->scintilla->style_set_back(SCINTILLA_STYLE_BRACE_LIGHT, 1);
      $this->scintilla->style_set_font(SCINTILLA_STYLE_BRACE_BAD, '-*-*-bold-*-*-*-*-*-*-*-*-*-*-*');
      $this->scintilla->style_set_fore(SCINTILLA_STYLE_BRACE_BAD, 1);
      $this->scintilla->style_set_back(SCINTILLA_STYLE_BRACE_BAD, 1);	    
	  
	  
	  

      //$this->scintilla->set_margin_type_n(2, 0);
      //$this->scintilla->set_margin_width_n(2, 0);
      //$this->scintilla->set_margin_width_n(1, 20);
	  $this->scintilla->set_margin_type_n(1, 3); //numbering
	  //$this->scintilla->set_margin_width_n(0, 3);
	  $this->scintilla->set_margin_width_n(1, 36);//set numbering marging
	  $this->scintilla->set_margin_left(10); //set left margin			  
      $this->scintilla->autoc_set_choose_single(TRUE);
      $this->scintilla->set_tab_indents(1);
      $this->scintilla->set_backspace_unindents(1);
      $this->scintilla->set_usize(200, 100);
      $this->scintilla->use_pop_up(1);
      $this->scintilla->show();
      	  
	  ///////////////////////////////////////////////////////////////
		
      $container->show_all();			  
	    
	}
	
	//experimental... create window scintilla under one base class
	function scintilla_window(&$container,$instance) {
	 
	  $this->{$instance} = &new GtkScintilla();
      $container->add($this->{$instance});
      $container->show_all();	 
	}
	
	function write($text,$pos=-1) {	  	
		  
		  if ($pos>0) $this->scintilla->insert_text($pos,$text);	
                 else $this->scintilla->insert_text($this->scintilla->get_current_pos(),$text);  	  
	}
	
	function writeln($text,$line=0) {
	      //echo $line,">>";
	
	      $eols = $this->scintilla->get_eol_mode(); //must be a \n
          $ctext = $this->scintilla->get_text();	
	      $max = strlen($ctext); //echo "<<<$max>>>";
	      $ln=0;
		  $pos = 0;
		  
		  while (($ln<$line) && ($pos<$max)) {
		    if ($ctext[$pos]=="\n") { 
			  //echo "+";
			  $ln+=1;
			}
			//echo $pos,">",$ctext[$pos]," ";
			$pos+=1;
		  }
		  
		  $this->scintilla->insert_text($pos,$text);	//echo $pos,">>";
		  
		  $this->text_changed();
	      //echo $ln,"\n";
	}
	
	function read() {
	
         return($this->scintilla->get_text());		
	}
	
	function instext($text) {
		  			  
		  $this->scintilla->set_text($text);	
		  
          $this->scintilla->set_read_only(0);
          $this->scintilla->set_save_point();
		  
		  //$this->highlight_braces();
    		  	  		  
	}
	
	function deltext() {	 	
		  	  
	}
	
	function readfile($file) {

	     $textfile = file($file);	
		 $out = implode("",$textfile);

		 return ($out);
	}	
	
	function writefile($file) {
	
	     //$text = $this->cedit->get_chars(0,-1);
		 $text = $this->scintilla->get_text();//0,-1);
	
         if ($fp = fopen ($file , "w")) {
                   fwrite ($fp, $text);
                   fclose ($fp);
				   
				   return (true);
	     }
	     else {
				   return (false);
		 }
	}	
	
	function text_changed() {
	
	      $this->changed_flag = true; //echo "z";
	}
	
	function ischanged() {
	      return ($this->changed_flag); //echo "?";
	}
	
	function setchange($truefalse) {

	      $this->changed_flag = $truefalse;
	}	
	
	
	////////////////////////////////////////////////// akbkhome
	
    function popup_check($event) {
	
        //global $application;
		
        if ($event->button != 3) return;
        /* show popup */
        
        //$this->scintilla->popup($application->scintilla_popup);
        
        
    }                   
	
	
    function get_current_word ($n=1 ) {
	
        if (!$this->scintilla) return;
        $this->curpos = $this->scintilla->get_current_pos();
        
        $this->scintilla->word_left_extend(); 
        $word = $this->scintilla->get_sel_text();
        $this->scintilla->goto_pos($this->curpos);
		
        return $word;
    } 
	
    function goto_line($line) {
	
        $line = $line -1;
        //echo "notice: scintilla got go to line $line";
        if (!$this->scintilla->get_line_visible($line))  {
              $this->expand($line);
        }  
        $this->scintilla->goto_line($line);
        $this->scintilla->grab_focus();
    }                   
	
    function is_brace() {
	
        if (!$this->scintilla) return;
		
        $braces = array(
                "[" =>1,
                "]" =>2,
                "{" =>3,
                "}" =>4,
                "(" =>5,
                ")" =>6);
        $position = $this->scintilla->get_current_pos();
        $ch = $this->scintilla->get_char_at($position - 1);
        if (@$braces[chr($ch)]) return $position - 1;
        $ch = $this->scintilla->get_char_at($position);
        if (@$braces[chr($ch)])  return $position;
        return -1;
    }        
	
    function highlight_braces() {
	
        if (!$this->scintilla) return;
		
        $brace_pos = $this->is_brace();
        if ($brace_pos > 0) {
            $other_pos = $this->scintilla->brace_match($brace_pos);
            if ($other_pos > 0)  {
                $this->scintilla->brace_highlight($brace_pos, $other_pos);
            } else {
                $this->scintilla->brace_bad_light($brace_pos);
            }
        } else {
           $this->scintilla->brace_bad_light(-1);
        }
    }                   
	           
	
	
    function set_language() { 
        global $application;
        if (!$this->scintilla) return;
         // currently ignores URL!
        
        //echo serialize($this->language)."\n";
        //$this->scintilla->set_word_chars(  "abcdefghijklmnopqrstuvwxyz_->$<[]");
        //$this->scintilla->set_tab_width( 1*  $application->langs->get_val($this->URL,"tab_size"));
        //$this->scintilla->set_use_tabs( 1*  !$application->langs->get_val($this->URL,"soft_tabs"));
        //$this->scintilla->set_indent(  1*    $application->langs->get_val($this->URL,"indent_size"));
        //$this->scintilla->set_indentation_guides( 1* $application->langs->get_val($this->URL,"show_indent"));
        //$this->set_auto_indent = $application->langs->get_val($this->URL,"auto_indent");
        //echo "SET EDGE MODE: " . $application->langs->get_val($this->URL,"edge_indicator") . "\n";
        
        //$this->scintilla->set_edge_mode(   1* $application->langs->get_val($this->URL,"edge_indicator"));
        //$this->scintilla->set_edge_column( 1* $application->langs->get_val($this->URL,"edge_column"));
        //$this->scintilla->set_edge_colour( 1*$application->langs->get_val($this->URL,"edge_color"));
        $this->scintilla->set_style_bits(5);
        
        $lexer = SCINTILLA_LEXER_HTML;//$application->langs->get_val($this->URL,"lexer");
        if (($lexer == SCINTILLA_LEXER_HTML) || 
              ($lexer == SCINTILLA_LEXER_XML)) 
            $this->scintilla->set_style_bits(7);
        
           
        $this->scintilla->set_lexer(SCINTILLA_LEXER_HTML*1);//$application->langs->get_val($this->URL,"lexer")*1);
        $this->scintilla->clear_document_style();
         
        for ($i= 0 ;$i< 5;$i++)   {
            //debug_echo("\nLOOKING FOR KEYWORD $i:");
            //if ($words = $application->langs->get_keywords($this->URL,$i+1))  {
            //    $this->scintilla->set_keywords($i, $words);
            //}
        }  
          //echo $this->keywords;  
        //$keys = $application->langs->get_style_keys($this->URL);
        if ($keys) 
            foreach ($keys as $k=>$v) {
                $this->set_back($k);
                $this->set_fore($k);
                $this->set_font($k);
            }
        $this->scintilla->colourise(0, -1);
        $this->add_folding();
    } 
	
    function search($what, $match_case=0,$whole_words=0,$word_start=0,$regex=0,$backwards=0) {
	
        if (!$this->scintilla) return;
		
        $this->search_flags = $backwards * SCINTILLA_FIND_DOWN +  
                $match_case * SCINTILLA_FIND_MATCH_CASE +  
                $whole_words * SCINTILLA_FIND_WHOLE_WORDS +  
                $word_start * SCINTILLA_FIND_WORD_START +  
                $regex * SCINTILLA_FIND_REGEXP;
                        
        $start =0;
        $end = $this->scintilla->get_length();
        if ($backwards) {
            $start = $this->scintilla->get_selection_start() - 1;
            $end = 0;
        } else {
            $start = $this->scintilla->get_selection_end();
            $end = $this->scintilla->get_length();
        }
        
        $result = $this->scintilla->find_text($this->search_flags, $what,  $start, $end );
        if ($result > -1) {
            if (!$this->scintilla->get_line_visible($this->scintilla->line_from_position($result)))  {
              $this->expand($this->scintilla->line_from_position($result));
            }  
            $this->scintilla->goto_line($this->scintilla->line_from_position($result));
            $this->scintilla->set_selection_start($result);
            $this->scintilla->set_selection_end($result + strlen($what));
            $found = 1;
        } else {
             $this->scintilla->set_selection_end( $this->scintilla->get_selection_start());
            $found = 0; 
        }
          
        //  $this->scintilla->ensure_visible($this->scintilla->line_from_position($result));
        $this->scintilla->grab_focus();
    }                   
	                  
    function replace($what,$with, $match_case=0,$whole_words=0,$word_start=0,$regex=0,$backwards=0) {
	
        if (!$this->scintilla) return;
		
        $this->search_flags = 
                $backwards * SCINTILLA_FIND_DOWN +  
                $match_case * SCINTILLA_FIND_MATCH_CASE +  
                $whole_words * SCINTILLA_FIND_WHOLE_WORDS +  
                $word_start * SCINTILLA_FIND_WORD_START +  
                $regex * SCINTILLA_FIND_REGEXP;
         
        $sel_start = $this->scintilla->get_selection_start();
        $sel_end = $this->scintilla->get_selection_end();
        $this->replace_multi($what,$with,1); // replace all!
        //$this->scintilla->set_selection_start($sel_start);
        $this->scintilla->grab_focus();
    }                   
	              
    function replace_multi($find_text,$replace_text,$all=0) {
	
       if (!$this->scintilla) return;
   
        $this->scintilla->begin_undo_action();
        $count = 0;
        $target_start = $target_end = 0;
        
        if ($all) {
            $replace_start = 0;
            $replace_end = $this->scintilla->get_length();
        } else { 
            $replace_start = $this->scintilla->get_selection_start();
            $replace_end = $this->scintilla->get_selection_end();
        }
        $regex = 0;
        $prompt_on = 0;
        $replace_action = 0;
        
        $result = $this->scintilla->find_text($this->search_flags, $find_text, $replace_start, $replace_end);
        while (($result > -1) && ($replace_action < 3)) {
            $target_start = $result;
            $target_end = $result + strlen($find_text);
            $this->scintilla->set_selection_start($target_start);
            $this->scintilla->set_selection_end($target_end);
            $this->scintilla->ensure_visible($this->scintilla->line_from_position($target_start));
            
            $replace_action = 0;
            if ($prompt_on) {
               //echo "PROMPT!";
                //$prompt_dialog = PromptDialog(doc.get_sel_text(), replace_text)
               //$replace_action = prompt_dialog.show()
            }
            if ($replace_action == 1) {
               $result = $this->scintilla->find_text($this->search_flags, $find_text,
                                       $target_end, $replace_end);
                continue;
            }    
            if ($replace_action == 2)    // all
                $prompt_on = 0;
            if ($replace_action == 4)   // cancel
                break;
             
            $count = $count + 1;
            //echo "SET TS $target_start TE $target_end \n";
            $this->scintilla->set_target_start($target_start);
            $this->scintilla->set_target_end($target_end);
            if ($regex) {
              $len_replace = $this->scintilla->replace_target_re($regex, $replace_text);
            } else {
              $len_replace = $this->scintilla->replace_target( $replace_text);
            }  
            $replace_start = $target_start + $len_replace;
            if (!$all) {
                $replace_end +=  ($len_replace - ($target_end - $target_start));
            } else {
                $replace_end =  $this->scintilla->get_length();
            }
            
            $result = $this->scintilla->find_text($this->search_flags, $find_text,
                                   $replace_start, $replace_end);
            //echo "RESULT IS : ".$result ."\n";
        }           
        $this->scintilla->goto_pos($this->scintilla->get_target_end());
        $this->scintilla->end_undo_action();
        //if ($replace_dialog != 4) {
            //gnome.ui.GnomeMessageBox(
            //            _('Done.\nReplaced %i strings.') % (count, ),
            //            gnome.uiconsts.MESSAGE_BOX_INFO,
            //            gnome.uiconsts.STOCK_BUTTON_OK).run_and_close()
        return $count;
    }                                     
	
	
	
	
	function _undo() {
	   global $shell;
	
	   if ($this->scintilla->can_undo()) {
         $shell->console->write("undo!!");			   
	   }
	   else
         $shell->console->write("NOT undo!!");		
	}
	
	function _redo() {
	   global $shell;
	
	   if ($this->scintilla->can_redo()) {
         $shell->console->write("redo!!");			   
	   }
	   else
         $shell->console->write("NOT redo!!");	
	}
	
	function _cut() {
	}		
	
	function _copy() {
	}	

	function _paste() {
	}	
	
	function _delete() {
	}	
	
	function _select_all() {
	}		
			
	function menu($container) {
	   global $T_project;

	   $header = &new GtkMenuItem("Edit");
	   
	   $editmenu = &new GtkMenu();	
	   
	   $udo = &new GtkMenuItem("Undo");
	   $udo->connect_object("activate", array($this, "_undo"),null);	   
	   $editmenu->append($udo);
	   
	   $rdo = &new GtkMenuItem("Redo");
	   $rdo->connect_object("activate", array($this, "_redo"),null);	   
	   $editmenu->append($rdo);	   
	   
	   $sep0 = &new GtkMenuItem();	      
	   $editmenu->append($sep0);		     
	   
	   $cut = &new GtkMenuItem("Cut");
	   $cut->connect_object("activate", array($this, "_cut"),null);	   
	   $editmenu->append($cut);	
	   
	   $cpy = &new GtkMenuItem("Copy");
	   $cpy->connect_object("activate", array($this, "_copy"),null);	   
	   $editmenu->append($cpy);	
	   
	   $pst = &new GtkMenuItem("Paste");
	   $pst->connect_object("activate", array($this, "_paste"),null);	   
	   $editmenu->append($pst);		   	   	   

	   $dlt = &new GtkMenuItem("Delete");
	   $dlt->connect_object("activate", array($this, "_delete"),null);	   
	   $editmenu->append($dlt);
	   
	   $sep1 = &new GtkMenuItem();	      
	   $editmenu->append($sep1);		   
	   
	   $selall = &new GtkMenuItem("Select All");
	   $selall->connect_object("activate", array($this, "_select_all"),null);	   
	   $editmenu->append($selall);	   	   

	   $header->set_submenu($editmenu);
	   
	   $container->append($header);	   	   
	}
	
	function free() {
	    
	     $this->scintilla->destroy();
		 $this->scintilla = null;
		 unset($this->scintilla);
	}			
	
}


	/* 
    function gtk_scintilla() {
        global $windows;
		global $shell;
		
        if (!isset($windows['scintilla'])) {	
		  		
		  $window = &new GtkWindow;
		  $windows['scintilla'] = $window;
		  $window->connect('delete-event', 'delete_event');
		  $window->set_title('Scintilla');
	      $window->set_usize(400, 250);		  
		  $window->set_border_width(0);
		  
		  $shell->scintilla = new scintilla($window);		  
		  
	      $window->show_all();	  							  
		}
        elseif ($windows['scintilla']->flags() & GTK_VISIBLE)
            $windows['scintilla']->hide();
        else
            $windows['scintilla']->show();			
	}	*/	
		
?>
