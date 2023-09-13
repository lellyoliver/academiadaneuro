function trainingQuestionsCheckboxes() {
    window.addEventListener('load', function () {
        const createQuestion = document.getElementById("create-question");
        fetch(`/academiadaneurociencia/wp-json/adn-plugin/data-question`)
            .then(response => response.json())
            .then(data => {
                console.log(data)
            })
    })

}

trainingQuestionsCheckboxes();