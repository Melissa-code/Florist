const searchFlower = document.getElementById("search-flower");
const cards = document.querySelectorAll(".card");

/**
 * Search the flower by name
 *
 * @param letters
 * @param elements
 */
function filterElements(letters, elements){

    let flowersList = document.getElementById('flowers-list');

    if(letters.length > 2) {
        searchFlower.style.borderColor = "green";
        for(let i = 0; i < elements.length; i++) {
            if(elements[i].textContent.toLowerCase().includes(letters)) {
                flowersList.insertBefore(elements[i], flowersList.firstElementChild);
                elements[i].style.display = "inline-block";
            } else {
                elements[i].style.display = "none";
            }
        }
    } else if(letters.length <= 2) {
        for(let i = 0; i < elements.length; i++) {
            elements[i].style.display = "inline-block";
        }
    }
}

/**
 * Event listener keyup in the searchbar
 */
searchFlower.addEventListener('keyup', (e)=> {
    const searchedLetters = e.target.value.toLowerCase();
    //console.log(searchedLetters);
    filterElements(searchedLetters, cards)
} )


