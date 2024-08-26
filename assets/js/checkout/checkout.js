const queryParams = window.location.search;

if (queryParams) {
  const params = new URLSearchParams(queryParams);
  const userId = params.get('user_related');

  if (userId) {
    const inputHiddenUserID = document.getElementById('billing_user_related');
    if (inputHiddenUserID) {
      inputHiddenUserID.value = userId;
    }
  }
}
