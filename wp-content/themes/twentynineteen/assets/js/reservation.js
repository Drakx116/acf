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

         const phone = document.getElementById('phone-' + reservation);
         const people = document.getElementById('people-' + reservation);
         const email = document.getElementById('email-' + reservation);

         jQuery.post({
            url: url,
            data: {
               'action': 'save_registration',
               'reservation': reservation,
               'phone': phone.value,
               'people': people.value,
               'email': email.value,
            }})
            .done(response => {
               console.log(response);
            });
      };
   }
}
