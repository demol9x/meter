<?php 
use yii\helpers\Url;
?>
<script type="text/javascript">
      //Getlocation
      function setGPSPosition(lat, lng) {
        jQuery.ajax({
            url: '<?= Url::to(['/site/set-location']) ?>',
            data:{lat : lat, lng: lng},
            beforeSend: function () {
            },
            success: function (res) {
                console.log(res);
                // location.reload();
            },
            error: function () {
            }
        });
      }
      // function onGeoSuccess(position) {
      //   var lat = position.coords.latitude;
      //   var lng = position.coords.longitude;
      //   // alert(lat+','+lng);
      //  setGPSPosition(lat, lng);
      // }
      // function onGeoError(error) {
      //   let detailError;
        
      //   if(error.code === error.PERMISSION_DENIED) {
      //     detailError = "User denied the request for Geolocation.";
      //   } 
      //   else if(error.code === error.POSITION_UNAVAILABLE) {
      //     detailError = "Location information is unavailable.";
      //   } 
      //   else if(error.code === error.TIMEOUT) {
      //     detailError = "The request to get user location timed out."
      //   } 
      //   else if(error.code === error.UNKNOWN_ERROR) {
      //     detailError = "An unknown error occurred."
      //   }
      //   console.log(detailError);
      // }
      // let geolocation = navigator.geolocation;
      // if (geolocation) {
      //     let options = {
      //       enableHighAccuracy: true,
      //       timeout: 5000,
      //       maximumAge: 0
      //     };
      //     geolocation.getCurrentPosition(onGeoSuccess, onGeoError, options);
      // } else {
      //   jQuery.ajax({
      //       url: '<?= Url::to(['/site/set-location']) ?>',
      //       data:{lat : 0, lng: 0},
      //       beforeSend: function () {
      //       },
      //       success: function (res) {
      //           console.log(res);
      //           // location.reload();
      //       },
      //       error: function () {
      //       }
      //   });
      // }
</script>