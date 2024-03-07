document.addEventListener("DOMContentLoaded", function () {
    const loadNotepadButton = document.getElementById("openNotepads");

    if (loadNotepadButton) {
        loadNotepadButton.addEventListener("click", function (event) {
            event.preventDefault();

            const xhr = new XMLHttpRequest();
            const inquiryId = document.getElementById('inquiryId').value;
            const userId = document.getElementById('userId').value;

            xhr.open("GET", `index.php?role=user&action=loadNotepad&inquiryId=${inquiryId}&userId=${userId}`, true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                    // Afficher le contenu du bloc-note récupéré dans votre interface utilisateur
                }
            };

            xhr.send();
        });
    }
});
