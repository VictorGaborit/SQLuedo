document.getElementById("openNotepad").addEventListener("click", openNotepad);
document.getElementById("closeNotepad").addEventListener("click", closeNotepad);
document.getElementById("openSolutions").addEventListener("click", openSolutions);
document.getElementById("closeSolutions").addEventListener("click", closeSolutions);
document.getElementById("openDiagram").addEventListener("click", openDiagram);
document.getElementById("closeDiagram").addEventListener("click", closeDiagram);
document.getElementById("cleanQuery").addEventListener("click", cleanQuery);
document.addEventListener('keydown', function (event) {
    console.log("Evènement déclenché");
    if (event.key === "Escape") {
        console.log("Touche Escape pressée !");
        closeActivePopup();
    }
});

// Fonction pour vérifier si la fenêtre popup est ouverte
let currentPopup = null

function closeActivePopup() {
    if (currentPopup !== null) {
        window["close" + currentPopup]();
    }
}

function cleanQuery() {
    document.getElementById("query-input").value = "";
    document.getElementById("cleanQuery").disabled = false;
}

function openSolutions() {
    document.getElementById("overlaySolution").style.display = "block";
    document.getElementById("openSolutions").disabled = true;
    document.getElementById("closeSolutions").disabled = false;
    currentPopup = "Solutions";
}

function closeSolutions() {
    document.getElementById("overlaySolution").style.display = "none";
    document.getElementById("openSolutions").disabled = false;
    document.getElementById("closeSolutions").disabled = true;
    currentPopup = null;
}

function openNotepad() {
    document.getElementById("overlayNotepad").style.display = "block";
    document.getElementById("openNotepad").disabled = true;
    document.getElementById("closeNotepad").disabled = false;
    currentPopup = "Notepad";
}

function closeNotepad() {
    document.getElementById("overlayNotepad").style.display = "none";
    document.getElementById("openNotepad").disabled = false;
    document.getElementById("closeNotepad").disabled = true;
    currentPopup = null;
}

function openDiagram() {
    document.getElementById("diagram").style.display = "block";
    document.getElementById("openDiagram").disabled = true;
    document.getElementById("closeDiagram").disabled = false;
    currentPopup = "Diagram";
}

function closeDiagram() {
    document.getElementById("diagram").style.display = "none";
    document.getElementById("openDiagram").disabled = false;
    document.getElementById("closeDiagram").disabled = true;
    currentPopup = null;
}

function checkSolution() {
    const meurtierInput = document.getElementById('meurtier').value.toLowerCase();
    const lieuInput = document.getElementById('lieu').value.toLowerCase();
    const objetInput = document.getElementById('objet').value.toLowerCase();

    if (meurtierInput && lieuInput && objetInput) {
        if (meurtierInput === 'emily navy' && lieuInput === 'bureau de richard' && objetInput === 'tubocurarine') {
            displayResultMessage('Bonne réponse !', 'inquirieschoice.html');
        } else {
            displayResultMessage('Mauvaise réponse. Veuillez réessayer.');
        }
    } else {
        displayResultMessage('Veuillez remplir tous les champs.');
    }

    return false;
}


function displayResultMessage(message, page) {
    alert(message);
    if (page) {
        window.open(page);
    }
}

function toggleText() {
    const longText = document.getElementById('longText');
    const toggleButton = document.getElementById('toggleButton');

    if (longText.classList.contains('collapsed')) {
        longText.classList.remove('collapsed');
        toggleButton.textContent = 'Réduire';
    } else {
        longText.classList.add('collapsed');
        toggleButton.textContent = 'Lire la suite...';
    }
}