jQuery(document).ready(() => {
   const url = window.location.origin + '/wp-admin/admin-ajax.php';

   handleReservation(url);
});

const handleReservation = url => {
   const reservationButtons = document.getElementsByClassName('reservation-btn');

   let current = 0;
   let again = true;

   while (again) {
      const button = reservationButtons.item(current);
      current++;

      if (!button) break; // * Break if no more button found

      button.onclick = e => {
         const target = e.target;
         const reservation = target.dataset.reservation;

         jQuery.post({
            url: url,
            data: {
               'action': 'save_registration',
               'reservation': reservation
            }})
            .done(response => {
               console.log(response);
            });
      };
   }
}
