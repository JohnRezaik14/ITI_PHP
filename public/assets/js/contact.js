export const delayRedirection = () => {
  setTimeout(() => {
    window.location.href = "http://localhost/messages.php";
  }, 2000);
};
if (document.querySelector(".success-message")) {
  delayRedirection();
}
