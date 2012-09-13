<?php


/***

array(
        'name'=>'', //nazwa css atrybutu
//        'type'=>'root', //typ atrybutu; typy: root-styl bazowy dla grupy styli, child-styl potomny dla stylu root
//        'children'=>array( //dzieci stylu
//            
//        ),
        'values'=>array( //wersja css obslugujaca atrybut ; [string,doubble,int,attr_name,color,auto]
            
        ),
        'unit'=>array( //dostepne jednostki dla atrybutu ; [px,dx,em,%]
            
        ),
        'default'=>'auto', //standardowa wartosc
        'version'=>'',
//        'text'=>'', //wyswietlana uzytkownikowi nazwa atrybutu ; pole tekst zawiera nazwe dla repozytorium tlumaczen
//        'description'=>'', //opis pomocy ; pole description zawiera nazwe dla repozytorium tlumaczen
    ),

*/

//echo 'include test successfull';


$objData = array(
    array(
        'name'=>'color', //nazwa css atrybutu
        'type'=>'root', //typ atrybutu; typy: root-styl bazowy dla grupy styli, child-styl potomny dla stylu root
        'children'=>array(),
        'values'=>array( //wersja css obslugujaca atrybut ; [string,doubble,int,attr_name,color,auto]
            'value','inherit'
        ),
        'units'=>array( //dostepne jednostki dla atrybutu ; [px,dx,em,%,pt,hex,rgb,]
            'hex','rgb'
        ),
        'default'=>'',
        'version'=>'1'
    ),
    array(
        'name'=>'margin', //nazwa css atrybutu
        'type'=>'root', //typ atrybutu; typy: root-styl bazowy dla grupy styli, child-styl potomny dla stylu root
        'children'=>array( //dzieci stylu
            'margin-top','margin-right','margin-bottom','margin-left'
        ),
        'values'=>array( //wersja css obslugujaca atrybut ; [string,doubble,int,attr_name,color,auto]
            'auto','value','inherit'
        ),
        'units'=>array( //dostepne jednostki dla atrybutu ; [px,dx,em,%,pt,hex,rgb,]
            'px','em'
        ),
        'default'=>'auto',
        'version'=>'1'
    ),
    array(
        'name'=>'margin-top', //nazwa css atrybutu
        'type'=>'child', //typ atrybutu; typy: root-styl bazowy dla grupy styli, child-styl potomny dla stylu root
        'children'=>array(),
        'values'=>array( //wersja css obslugujaca atrybut ; [string,doubble,int,attr_name,color,auto]
            'auto','value','inherit'
        ),
        'units'=>array( //dostepne jednostki dla atrybutu ; [px,dx,em,%,pt,hex,rgb,]
            'px','em'
        ),
        'version'=>'1'
    ),
    array(
        'name'=>'margin-right', //nazwa css atrybutu
        'type'=>'child', //typ atrybutu; typy: root-styl bazowy dla grupy styli, child-styl potomny dla stylu root
        'children'=>array(),
        'values'=>array( //wersja css obslugujaca atrybut ; [string,doubble,int,attr_name,color,auto]
            'auto','value','inherit'
        ),
        'units'=>array( //dostepne jednostki dla atrybutu ; [px,dx,em,%,pt,hex,rgb,]
            'px','em'
        ),
        'version'=>'1'
    ),
    array(
        'name'=>'margin-bottom', //nazwa css atrybutu
        'type'=>'child', //typ atrybutu; typy: root-styl bazowy dla grupy styli, child-styl potomny dla stylu root
        'children'=>array(),
        'values'=>array( //wersja css obslugujaca atrybut ; [string,doubble,int,attr_name,color,auto]
            'auto','value','inherit'
        ),
        'units'=>array( //dostepne jednostki dla atrybutu ; [px,dx,em,%,pt,hex,rgb,]
            'px','em'
        ),
        'version'=>'1'
    ),
    array(
        'name'=>'margin-left', //nazwa css atrybutu
        'type'=>'child', //typ atrybutu; typy: root-styl bazowy dla grupy styli, child-styl potomny dla stylu root
        'children'=>array(),
        'values'=>array( //wersja css obslugujaca atrybut ; [string,doubble,int,attr_name,color,auto]
            'auto','value','inherit'
        ),
        'units'=>array( //dostepne jednostki dla atrybutu ; [px,dx,em,%,pt,hex,rgb,]
            'px','em'
        ),
        'version'=>'1'
    ),
    
//    'background-attachment':['scroll','fixed','inherit'],
//	'background-color':['color','transparent','inherit'],
//	'background-image':['url','none','inherit'],
//	'background-position':['value','top','bottom','left','right','top left','top center','top right','center left','center center','center right','bottom left','bottom center','bottom right','inherit'],
//	'background-repeat':['repeat','repeat-x','repeat-y','no-repeat','inherit'],
//	//'background':[ ['background-color','background-image','background-repeat','background-attachment','background-position','inherit'] ],
//	'border-collapse':['collapse','separate','inherit'],
//	'border-color':['color','transparent','inherit'],
//	'border-spacing':['value','value','inherit'],
//	'border-style':['none','hidden','dotted','dashed','solid','double','groove','ridge','inset','outset','inherit'],
//	//'border-top':[ ['border-width','border-style','border-top-color','inherit'] ],
//	//'border-right':[ ['border-width','border-style','border-right-color','inherit'] ],
//	//'border-bottom':[ ['border-width','border-style','border-bottom-color','inherit'] ],
//	//'border-left':[ ['border-width','border-style','border-left-color','inherit'] ],
//	//'border-top-color':[ ['color','transparent','inherit'] ],
//	//'border-right-color':[ ['color','transparent','inherit'] ],
//	//'border-bottom-color':[ ['color','transparent','inherit'] ],
//	//'border-left-color':[ ['color','transparent','inherit'] ],
//	//'border-top-style': [ ['border-style','inherit'] ],
//	//'border-right-style': [ ['border-style','inherit'] ],
//	//'border-bottom-style': [ ['border-style','inherit'] ],
//	//'border-left-style': [ ['border-style','inherit'] ],
//	//'border-top-width': [ ['border-width','inherit'] ],
//	//'border-right-width': [ ['border-width','inherit'] ],
//	//'border-bottom-width': [ ['border-width','inherit'] ],
//	//'border-left-width': [ ['border-width','inherit'] ],
//	'border-width':['value','inherit'],
//	//'border': [ ['border-width','border-style','border-top-color','inherit'] ]
//	'outline-color':['color','invert'],
//	'outline-style':['none','hidden','dotted','dashed','solid','double','groove','ridge','inset','outset','inherit'],
//	'outline-width':['value','inherit'],
//	//'outline' 	[ 'outline-color' || 'outline-style' || 'outline-width' ] | inherit 	see individual properties 	  	no 	  	visual, interactive
//	
//	'color':['color','inherit'],
//	'font-family':['family-name'],
//	'font-size':['absolute-size','relative-size','value','percentage','inherit','medium'],
//	'font-style':['normal','italic','oblique','inherit','normal'],
//	'font-variant':['normal','small-caps','inherit'],
//	'font-weight':['normal','bold','bolder','lighter','100','200','300','400','500','600','700','800','900','inherit'],
//	'line-height':['normal','number','value','percentage','inherit'],
//	'letter-spacing':['normal','value','inherit'],
//	'text-align':['left','right','center','justify','inherit'],
//	'text-decoration':['none','underline','overline','line-through','blink','inherit'],
//	'text-indent':['value','percentage','inherit'],
//	'text-transform':['capitalize','uppercase','lowercase','none','inherit'],
//	'vertical-align':['baseline','sub','super','top','text-top','middle','bottom','text-bottom','percentage','value','inherit'],
//	'word-spacing':['normal','value','inherit'],
//	'white-space':['normal','pre','nowrap','pre-wrap','pre-line','inherit'],
//	//'font':[ ['font-style','font-variant','font-weight','font-size','line-height','font-family' ] | caption | icon | menu | message-box | small-caption | status-bar | inherit 
//	
//	
//	'position':['static','relative','absolute','fixed','inherit'],
//	//'bottom':['auto','value','percentage','inherit'],
//	'top':['auto','value','percentage','inherit'],
//	'left':['auto','value','percentage','inherit'],
//	'float':['none','left','right','inherit'],
//	'clear':['none','left','right','both','inherit'],
//	
//	//'right':['auto','value','percentage','inherit'],
//	
//	'width':['auto','value','percentage','inherit'],
//	'height':['auto','value','percentage','inherit'],
//	'margin-right':['value','inherit'],
//	'margin-left':['value','inherit'],
//	'margin-top':['value','inherit'],
//	'margin-bottom':['value','inherit'],
//	//'margin':['margin-width>{1,4}','inherit'],
//	'padding-top':['value','inherit'],
//	'padding-right':['value','inherit'],
//	'padding-bottom':['value','inherit'],
//	'padding-left':['value','inherit'],
//	//'padding':['padding-width>{1,4}','inherit'],
//	'max-height':['none','value','percentage','inherit'],
//	'max-width':['none','value','percentage','inherit'],
//	'min-height':['value','percentage','inherit'],
//	'min-width':['value','percentage','inherit'],
//	
//	//inne
//	'display':['inline','block','list-item','run-in','inline-block','table','inline-table','table-row-group','table-header-group','table-footer-group','table-row','table-column-group','table-column','table-cell','table-caption','none','inherit'],
//	'cursor':['auto','crosshair','default','pointer','move','e-resize','ne-resize','nw-resize','n-resize','se-resize','sw-resize','s-resize','w-resize','text','wait','help','progress'],
//	'overflow':['visible','hidden','scroll','auto','inherit'],
//	'z-index':['auto','integer','inherit'],
//	'visibility':['visible','hidden','collapse','inherit'],
);

?>
