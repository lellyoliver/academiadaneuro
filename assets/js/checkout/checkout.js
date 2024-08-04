
const queryString = window.location.search;
if(queryString){
  if (queryString.includes('?user_related=')) {
    const user_id = queryString.split('?user_related=')[1];
    const inputHiddenUserID = document.getElementById('billing_user_related');
    inputHiddenUserID.value = user_id;
  }
}
