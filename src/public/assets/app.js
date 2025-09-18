const newsList = document.getElementById('newsList');
const newsForm = document.getElementById('newsForm');
const newsId = document.getElementById('newsId');
const newsTitle = document.getElementById('newsTitle');
const newsBody = document.getElementById('newsBody');

async function fetchNews() {
    const res = await fetch('/api.php', {
        method: 'POST',
        body: new URLSearchParams({ action: 'all' })
    });
    const data = await res.json();
    newsList.innerHTML = '';
    data.forEach(item => {
        const li = document.createElement('li');
        li.dataset.id = item.id;
        li.innerHTML = `<strong>${item.title}</strong>
            <p>${item.body.replace(/\n/g,'<br>')}</p>
            <button onclick="editNews(${item.id}, '${escapeJs(item.title)}', '${escapeJs(item.body)}')">Szerkeszt</button>
            <button onclick="deleteNews(${item.id})">Töröl</button>`;
        newsList.appendChild(li);
    });
}

function escapeJs(str) {
    return str.replace(/'/g, "\\'").replace(/\n/g, "\\n");
}

newsForm.addEventListener('submit', async e => {
    e.preventDefault();
    const action = newsId.value ? 'update' : 'create';
    const res = await fetch('/api.php', {
        method: 'POST',
        body: new URLSearchParams({
            action,
            id: newsId.value,
            title: newsTitle.value,
            body: newsBody.value
        })
    });
    const data = await res.json();
    if (data.success) {
        // reset form
        newsId.value = '';
        newsTitle.value = '';
        newsBody.value = '';
        fetchNews();
    } else {
        alert('Hiba történt a mentés során');
    }
});

function editNews(id, title, body) {
    newsId.value = id;
    newsTitle.value = title;
    newsBody.value = body;
}

// Törlés gomb
async function deleteNews(id) {
    if (!confirm('Biztos törlöd?')) return;
    const res = await fetch('/api.php', {
        method: 'POST',
        body: new URLSearchParams({ action: 'delete', id })
    });
    const data = await res.json();
    if (data.success) {
        // töröljük a form mezőket, ha a törölt hír épp a formban van
        if (newsId.value == id) {
            newsId.value = '';
            newsTitle.value = '';
            newsBody.value = '';
        }
        fetchNews();
    }
}

// oldal betöltéskor hírek
fetchNews();
