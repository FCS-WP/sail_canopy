// import { DisplayLabel } from './components/DisplayLabel';

let Main = {
  init: async function () {

    // initialize demo javascript component - async/await invokes some 
    //  level of babel transformation 
    const displayLabel = new DisplayLabel();
    await displayLabel.init();

  }
};


console.log($('.more-link'));
// Main.init();

document.getElementById('btn_sidebar').addEventListener('click', function() {
  const sidebar = document.getElementById('sidebar_custom');
  sidebar.classList.toggle('toggle-sidebar');
});

document.getElementById('btn_close_sidebar').addEventListener('click', function() {
  const sidebar = document.getElementById('sidebar_custom');
  sidebar.classList.toggle('toggle-sidebar');
});