jQuery(function($) {
    $(document).ready(function() {
      //fixes for IE 11
      if('objectFit' in document.documentElement.style === false) {
        //see if this is a blog page where we are applying our custom function
        var blog_left_layout = $('.blog-left-layout.et_pb_posts .et_pb_post a img');
        if(blog_left_layout.length > 0){
          // assign HTMLCollection with parents of images with objectFit to variable
          blog_left_layout.each(function() {
            // $(this).css('height', 'auto');
          });
        } //end if(blog_left_layout.length)
      } //end if('objectFit' in document.documentElement.style === false)
    }); //end $(document).ready(function()
});
