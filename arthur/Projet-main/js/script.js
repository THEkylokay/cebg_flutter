function autocompletcommune() {
    var nomId = 'nom_idcommune';
    var nomListId = 'nom_list_idcommune';
    var min_length = 2;
    var keyword = $('#' + nomId).val();

    if (keyword.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword: keyword,
                type: 'commune'
            },
            success: function(data) {
                $('#' + nomListId).show();
                $('#' + nomListId).html(data);
            }
        });
    } else {
        $('#' + nomListId).hide();
    }
}

function set_item(item, item2, item3) {
    $('#nom_idcommune').val(item);
    $('#cp').val(item2);
    $('#idcommune').val(item3);
    $('#nom_list_idcommune').hide();
}


function autocompletcommune21(cavalier_id) {
    var nomId21 = 'nom_idcommune21_'+ cavalier_id;
    var nomListId21 = 'nom_list_idcommune21_'+ cavalier_id;
    var min_length = 2;
    var keyword21 = $('#' + nomId21).val();

    if (keyword21.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword21: keyword21,
                cavalier_id: cavalier_id

            },
            success: function(data) {
                $('#' + nomListId21).show();
                $('#' + nomListId21).html(data);
            }
        });
    } else {
        $('#' + nomListId21).hide();
    }
}
function set_item21(item, item2, item3, cavalier_id) {
    $(`#nom_idcommune21_${cavalier_id}`).val(item);
    $(`#cp21_${cavalier_id}`).val(item2);
    $(`#idcommune21_${cavalier_id}`).val(item3);
    $(`#nom_list_idcommune21_${cavalier_id}`).hide();
}
function autocompletgalop() {
    var min_length = 2;
    var keyword = $('#nom_idgalop').val();

    if (keyword.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword: keyword,
                type: 'galop'
            },
            success: function(data) {
                $('#nom_list_idgalop').show();
                $('#nom_list_idgalop').html(data);
            }
        });
    } else {
        $('#nom_list_idgalop').hide();
    }
}

function set_item2(item, item3) {
    $('#nom_idgalop').val(item);
    $('#idgalop').val(item3);
    $('#nom_list_idgalop').hide();
}


function autocompletgalop22(cavalier_id) {
    var nomId22 = 'nom_idgalop22_'+ cavalier_id;
    var nomListId22 = 'nom_list_idgalop22_'+ cavalier_id;
    var min_length = 2;
    var keyword22 = $('#' + nomId22).val();

    if (keyword22.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword22: keyword22,
                type : 'galop',
                cavalier_id: cavalier_id
            },
            success: function(data) {
                $('#' + nomListId22).show();
                $('#' + nomListId22).html(data);
            }
        });
    } else {
        $('#' + nomListId22).hide();
    }
}



function set_item22(item, item3, cavalier_id) {
    $(`#nom_idgalop22_${cavalier_id}`).val(item);
    $(`#idgalop22_${cavalier_id}`).val(item3);
    $(`#nom_list_idgalop22_${cavalier_id}`).hide();
}


function autocompletrobe() {
    var min_length = 2;
    var keyword = $('#nom_idrobe').val();
    if (keyword.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword: keyword,
                type: 'robe'
            },
            success: function(data) {
                $('#nom_list_idrobe').show();
                $('#nom_list_idrobe').html(data);
            }
        });
    } else {
        $('#nom_list_idrobe').hide();
    }
}

function set_item3(item, item3) {
    $('#nom_idrobe').val(item);
    $('#idrobe').val(item3);
    $('#nom_list_idrobe').hide();
}

function autocompletrace() {
    var min_length = 2;
    var keyword = $('#nom_idrace').val();
    if (keyword.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword: keyword,
                type: 'race'
            },
            success: function(data) {
                $('#nom_list_idrace').show();
                $('#nom_list_idrace').html(data);
            }
        });
    } else {
        $('#nom_list_idrace').hide();
    }
}

function set_item4(item, item3) {
    $('#nom_idrace').val(item);
    $('#idrace').val(item3);
    $('#nom_list_idrace').hide();
}

function autocompletCheval() {
    var min_length = 2;
    var keyword = $('#nom_cheval').val();

    if (keyword.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword: keyword,
                type: 'cheval'
            },
            success: function(data) {
                $('#nom_list_cheval').show();
                $('#nom_list_cheval').html(data);
            }
        });
    } else {
        $('#nom_list_cheval').hide();
    }
}

function set_item_cheval(nom, sire) {
    $('#nom_cheval').val(nom);
    $('#numsire').val(sire);
    $('#nom_list_cheval').hide();
}

function autocompletCours() {
    var min_length = 2;
    var keyword = $('#nom_idcours').val();

    if (keyword.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword: keyword,
                type: 'cours'
            },
            success: function(data) {
                $('#nom_list_idcours').show();
                $('#nom_list_idcours').html(data);
            }
        });
    } else {
        $('#nom_list_idcours').hide();
    }
}

function set_item_cours_base(libelle, id) {
    $('#nom_idcours').val(libelle);
    $('#idcours').val(id);
    $('#nom_list_idcours').hide();
}

function autocompletCavalier() {
    var min_length = 2;
    var keyword = $('#nomcavalier').val();

    if (keyword.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword: keyword,
                type: 'cavalier'
            },
            success: function(data) {
                $('#nom_list_idcavalier').show();
                $('#nom_list_idcavalier').html(data);
            }
        });
    } else {
        $('#nom_list_idcavalier').hide();
    }
}

function set_item_cavalier(nom, prenom, id) {
    $('#nomcavalier').val(nom);
    $('#prenomcavalier').val(prenom);
    $('#idcavalier').val(id);
    $('#nom_list_idcavalier').hide();
}

function autocompletcavalier22(idcavalier) {
    var nomId22 = 'nom_idcavalier22_' + idcavalier;
    var nomListId22 = 'nom_list_idcavalier22_' + idcavalier;
    var min_length = 2;
    var keyword22 = $('#' + nomId22).val();

    if (keyword22.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword22: keyword22,
                type: 'cavalier',
                idcavalier: idcavalier
            },
            success: function(data) {
                $('#' + nomListId22).show();
                $('#' + nomListId22).html(data);
            }
        });
    } else {
        $('#' + nomListId22).hide();
    }
}

function set_item_cavalier22(item, item3, idcavalier) {
    $('#nom_idcavalier22_' + idcavalier).val(item);
    $('#idcavalier22_' + idcavalier).val(item3);
    $('#nom_list_idcavalier22_' + idcavalier).hide();
}

function autocompletcours21(idcours) {
    var nomId21 = 'nom_idcours21_' + idcours;
    var nomListId21 = 'nom_list_idcours21_' + idcours;
    var min_length = 2;
    var keyword21 = $('#' + nomId21).val();

    if (keyword21.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword21: keyword21,
                idcours: idcours
            },
            success: function(data) {
                $('#' + nomListId21).show();
                $('#' + nomListId21).html(data);
            }
        });
    } else {
        $('#' + nomListId21).hide();
    }
}

function set_item_cours21(item, item3, idcours) {
    $('#nom_idcours21_' + idcours).val(item);
    $('#idcours21_' + idcours).val(item3);
    $('#nom_list_idcours21_' + idcours).hide();
}

// Autocomplétion pour la robe en mode édition
function autocompletrobe_edit(numsire) {
    var min_length = 2;
    var keyword = $('#nom_idrobe_' + numsire).val();

    if (keyword.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword: keyword,
                type: 'robe_list',
                numsire: numsire
            },
            success: function(data) {
                $('#nom_list_idrobe_' + numsire).show();
                $('#nom_list_idrobe_' + numsire).html(data);
            }
        });
    } else {
        $('#nom_list_idrobe_' + numsire).hide();
    }
}

// Set item pour la robe en mode édition
function set_item_robe_edit(item, item3, numsire) {
    $('#nom_idrobe_' + numsire).val(item);
    $('#idrobe_' + numsire).val(item3);
    $('#nom_list_idrobe_' + numsire).hide();
}

// Autocomplétion pour la race en mode édition
function autocompletrace_edit(numsire) {
    var min_length = 2;
    var keyword = $('#nom_idrace_' + numsire).val();

    if (keyword.length >= min_length) {
        $.ajax({
            url: '../../includes/ajax_refresh.php',
            type: 'POST',
            data: {
                keyword: keyword,
                type: 'race_list',
                numsire: numsire
            },
            success: function(data) {
                $('#nom_list_idrace_' + numsire).show();
                $('#nom_list_idrace_' + numsire).html(data);
            }
        });
    } else {
        $('#nom_list_idrace_' + numsire).hide();
    }
}

// Set item pour la race en mode édition
function set_item_race_edit(item, item3, numsire) {
    $('#nom_idrace_' + numsire).val(item);
    $('#idrace_' + numsire).val(item3);
    $('#nom_list_idrace_' + numsire).hide();
}

document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('menu-button');
    const sidebar = document.querySelector('.sidebar');
    let lastScrollTop = 0; // Variable pour stocker la position de défilement précédente

    // Afficher la sidebar au survol du bouton menu
    menuButton.addEventListener('mouseenter', function() {
        sidebar.classList.add('active'); // Ajouter la classe active pour afficher la sidebar
    });

    // Afficher la sidebar au survol de la sidebar
    sidebar.addEventListener('mouseenter', function() {
        sidebar.classList.add('active'); // Garder la sidebar affichée
    });

    // Masquer la sidebar lorsque la souris quitte le menu ou la sidebar
    sidebar.addEventListener('mouseleave', function() {
        sidebar.classList.remove('active'); // Retirer la classe active pour masquer la sidebar
    });

    menuButton.addEventListener('mouseleave', function() {
        // Vérifier si la souris est toujours sur la sidebar
        if (!sidebar.matches(':hover')) {
            sidebar.classList.remove('active'); // Retirer la classe active pour masquer la sidebar
        }
    });

    const scrollToTopButton = document.getElementById('scroll-to-top');

    // Afficher ou masquer le bouton en fonction du défilement
    window.addEventListener('scroll', function() {
        if (window.scrollY > 300) { // Afficher le bouton si on a défilé de plus de 300px
            scrollToTopButton.style.display = 'flex';
        } else {
            scrollToTopButton.style.display = 'none';
        }

        // Vérifier la direction du défilement
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTop > lastScrollTop && sidebar.classList.contains('active')) {
            // Si on défile vers le bas et que la sidebar est active, la désactiver
            sidebar.classList.remove('active');
        }
        lastScrollTop = scrollTop; // Mettre à jour la position de défilement précédente
    });

    // Faire défiler vers le haut lorsque le bouton est cliqué
    scrollToTopButton.addEventListener('click', function() {
        // Ajouter la classe d'animation
        scrollToTopButton.classList.add('animate');

        // Faire défiler vers le haut
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // Défilement en douceur
        });

        // Retirer la classe d'animation après un court délai
        setTimeout(function() {
            scrollToTopButton.classList.remove('animate');
        }, 500); // Correspond à la durée de l'animation
    });
});