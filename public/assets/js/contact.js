export const delayRedirection = () => {
  setTimeout(() => {
    window.location.href = "http://localhost/os/php/messages.php";
  }, 2000);
};
if (document.querySelector(".success-message")) {
  delayRedirection();
}
