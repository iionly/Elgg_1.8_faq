<?php

?>

.hitcount {
    color: #cccccc;
    white-space: nowrap;
}

.faqedit {
    margin: 2px 2px 0 4px;
    cursor: pointer;
    width:14px;
    height:14px;
    background: url("<?php echo $vars['url']; ?>mod/faq/_graphics/edit.png") no-repeat 0 0;
}

.answer {
    display: none;
    border-left:1px solid #cccccc;
    border-top:1px solid #cccccc;
    border-right:1px solid #cccccc;
    border-bottom:1px solid #cccccc;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    padding-left: 5px;
}

.askedQuestion {
    border-bottom: solid 1px;
    border-color: #cccccc;
}

.askedLink {
    text-align: left;
    width:100%;
}

.askedSince {
    text-align: right;
    white-space: nowrap;
    color: grey;
}

.askedAnswer {
    display:none;
    margin: 10px 0 10px 0;
    padding: 3px;
}

/* category list */
.listEditBegin {

}

.listEditOptions {
    display: none;
}

.faqSelect {
    display:none;
}

.faqCategorySidebar a {
    display: block;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    border-radius: 8px;
    background-color: white;
    margin: 3px 0 5px 0;
    padding: 2px 4px 2px 8px;
}

.faqCategorySidebar a:hover {
    background: #0054A7;
    color: white;
    text-decoration: none;
}
