const list =  document.querySelector('#myDropdown');
const btn = document.querySelector('#btndrop');
btn.addEventListener('click', () => {
    list.classList.toggle('drop');
})


window.addEventListener('click', (e) => {
    if (e.target.matches('.dropbtn')) {
        let dropdowns = document.getElementsByClassName("dropdown-content");
        for (let i = 0; i < dropdowns.length; i++) {
            let openDropDown = dropdowns[i];
            if (openDropDown.classList.contains('drop')) {
                openDropDown.classList.remove('drop');
            }
        }
    }
})