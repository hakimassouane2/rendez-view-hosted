jQuery(function($) {

  var file_frame;

  $(document).on('click', '#ovaem_sponsor_logo a.gallery-add', function(e) {

    e.preventDefault();

    var name = $(this).data('name');
    var parent_el = $(this).parent();
    var append = $(this).data('res');
    

    if (file_frame) file_frame.close();

    file_frame = wp.media.frames.file_frame = wp.media({
      title: $(this).data('uploader-title'),
      button: {
        text: $(this).data('uploader-button-text'),
      },
      multiple: false
    });

    file_frame.on('select', function() {
      var listIndex = $(this).parent().find(' #image-metabox-list li').index($(this).parent().find(' #image-metabox-list li:last')),
          selection = file_frame.state().get('selection');

      selection.map(function(attachment, i) {
        attachment = attachment.toJSON(),
        index      = listIndex + (i + 1);

        var image_source;
        if (typeof attachment.sizes.thumbnail !== "undefined") {
            image_source = attachment.sizes.thumbnail.url;
        } else {
            image_source = attachment.sizes.full.url;
        }

         
        

        $(append).html('').append('<li><input class="sponsor_info_logo" type="hidden" name="'+name+'" value="' + attachment.id + '"><img width="50" class="image-preview" src="' + image_source + '"></li>');

      });
    });

   

    makeSortable();
    
    file_frame.open();

  });

  

  function resetIndex() {
    $('#image-metabox-list li').each(function(i) {
      $(this).find('input:hidden').attr('name', 'ovaem_gallery_id[' + i + ']');
    });
  }

  function makeSortable() {
    $('#image-metabox-list').sortable({
      opacity: 0.6,
      stop: function() {
        resetIndex();
      }
    });
  }

  $(document).on('click', '#ovaem_sponsor_logo a.remove-image', function(e) {
    e.preventDefault();

    $(this).parents('li').animate({ opacity: 0 }, 200, function() {
      $(this).remove();
      resetIndex();
    });
  });

  makeSortable();




  // Logo Upload
  // The "Upload" button
  $('.upload_image_button').on('click', function() {

      var send_attachment_bkp = wp.media.editor.send.attachment;
      var button = $(this);
      wp.media.editor.send.attachment = function(props, attachment) {
          $(button).parent().parent().find('.img_logo').hide();
          $(button).parent().parent().find('.img_logo_2').show();
          $(button).parent().parent().find('.img_logo_2').attr('src', attachment.url);
          $(button).prev().val(attachment.id);
          wp.media.editor.send.attachment = send_attachment_bkp;
      }
      wp.media.editor.open(button);
      return false;
  });

  // The "Remove" button (remove the value from input type='hidden')
  $('.remove_image_button').click(function() {
      var answer = confirm('Are you sure?');
      if (answer == true) {
          var src = $(this).parent().prev().attr('data-src');
          $(this).parent().prev().attr('src', src);
          $(this).prev().prev().val('');
          $(this).parent().parent().find('img').hide();
      }
      return false;
  });


  // PDF Attach
  $('.upload_pdf_button').off('click').on('click', function() {

      var send_attachment_bkp = wp.media.editor.send.attachment;
      var button = $(this);
      wp.media.editor.send.attachment = function(props, attachment) {
        
        if(attachment.type == 'image'){
          $(button).parent().parent().find('.file_ticket').hide();
          $(button).parent().parent().find('.img_ticket').hide();
          $(button).parent().parent().find('.file_ticket_2').hide();
          $(button).parent().parent().find('.img_ticket_2').show();
          $(button).parent().parent().find('.img_ticket_2').attr('src', attachment.url);

        };


        if(attachment.type == 'text' || attachment.type == 'application'){

          $(button).parent().parent().find('.file_ticket').hide();
          $(button).parent().parent().find('.img_ticket').hide();
          $(button).parent().parent().find('.img_ticket_2').hide();
          $(button).parent().parent().find('.file_ticket_2').show();
          $(button).parent().parent().find('.file_ticket_2').html(attachment.filename);
        };
     
          $(button).prev().val(attachment.id);
          wp.media.editor.send.attachment = send_attachment_bkp;
      }
      wp.media.editor.open(button);
      return false;
  });

  // The "Remove" button (remove the value from input type='hidden')
  $('.remove_pdf_button').click(function() {
      var answer = confirm('Are you sure?');
      if (answer == true) {
          var src = $(this).parent().prev().attr('data-src');
          $(this).parent().prev().attr('src', src);
          $(this).prev().prev().val('');
          $(this).parent().parent().find('img').hide();
          $(this).parent().parent().find('a').hide();
      }
      return false;
  });



});