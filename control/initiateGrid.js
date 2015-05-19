$(document).ready(function(){

      $(function () {

            $('.grid-stack').gridstack({
           
            // turns animation on
            animate: false,
           
            // if false it tells to do not initialize existing items

            auto: true,
           
            // amount of columns
            width: 12,
           
            // maximum rows amount
            height: 0,
           
            // widget class
            item_class: 'grid-stack-item',
           
            // class for placeholder
            placeholder_class: 'grid-stack-placeholder',
           
            // draggable handle selector
            handle: '.grid-stack-item-content',
           
            // one cell height
            //cell_height: 60,
           
            // vertical gap size
            vertical_margin: 20,
           
            // if false it tells to do not initialize existing items
            auto: true,
             
            // minimal width.
            min_width: 768,
           
            // enable floating widgets
            float: false,
           
            // vertical gap size
            vertical_margin: 20,
           
            // if true the resizing handles are shown even the user is not hovering over the widget
            always_show_resize_handle: false,
           
            // allows to owerride jQuery UI draggable options
            draggable: {handle: '.grid-stack-item-content', scroll: true, appendTo: 'body'},
           
            // allows to owerride jQuery UI resizable options
            resizable: {autoHide: true, handles: 'se'}
           
            });
          
          });
});