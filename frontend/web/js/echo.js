$('.lazy').Lazy({
      // your configuration goes here
      scrollDirection: 'vertical',
      effect: 'fadeIn',
      visibleOnly: true,
      effectTime: 500,
      threshold: 0,
      // called before an elements gets handled
      beforeLoad: function(element) {
          var imageSrc = element.data('src');
          // console.log('image "' + imageSrc + '" is about to be loaded');
      },
      
      // called after an element was successfully handled
      afterLoad: function(element) {
          $('.lazy').closest('.relative').addClass('open');
          var imageSrc = element.data('src');
          // console.log('image "' + imageSrc + '" was loaded successfully');
      },
      
      // called whenever an element could not be handled
      onError: function(element) {
          var imageSrc = element.data('src');
          // console.log('image "' + imageSrc + '" could not be loaded');
      }
  });