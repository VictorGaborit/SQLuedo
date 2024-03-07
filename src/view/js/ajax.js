document.addEventListener("DOMContentLoaded", function () {
    const basePath = window.basePath || window.location.origin;
    console.log(basePath)
    const notepadInput = document.getElementById("notepadInput");

    if (notepadInput) {
        notepadInput.addEventListener("input", function (event) {
            event.preventDefault(); // Empêche la soumission normale du formulaire

            const notepadValue = notepadInput.value;
            const inquiryId = document.getElementById('inquiryId').value;
            const userId = document.getElementById('userId').value;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", basePath + "/user/saveNotes", true);

            // Utilisez FormData pour gérer l'encodage des données
            const formData = new FormData();
            formData.append('notepad', notepadValue);
            formData.append('inquiryId', inquiryId);
            formData.append('userId', userId);

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Traitement de la réponse du serveur si nécessaire
                    console.log(xhr.responseText);
                }
            };

            // Envoyez les données FormData au lieu d'une chaîne simple
            xhr.send(formData);
        });
    }
});
