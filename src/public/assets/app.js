const newsList = document.getElementById('newsList');
const newsForm = document.getElementById('newsForm');
const newsId = document.getElementById('newsId');
const newsTitle = document.getElementById('newsTitle');
const newsBody = document.getElementById('newsBody');

const apiEndpoint = '/api.php';

const escapeJs = str => str.replace(/'/g, "\\'").replace(/\n/g, "\\n");

const renderNewsList = items => {
    newsList.innerHTML = '';
    items.forEach(item => {
        const li = document.createElement('li');
        li.dataset.id = item.id;
        li.innerHTML = `
            <strong>${item.title}</strong>
            <p>${item.body.replace(/\n/g,'<br>')}</p>
            <button onclick="editNews(${item.id}, '${escapeJs(item.title)}', '${escapeJs(item.body)}')">Edit</button>
            <button onclick="deleteNews(${item.id})">Delete</button>
        `;
        newsList.appendChild(li);
    });
};

const fetchNews = async () => {
    const res = await fetch(apiEndpoint, { method: 'GET' });
    const data = await res.json();
    if (data.success) renderNewsList(data.data);
};

newsForm.addEventListener('submit', async e => {
    e.preventDefault();
    const id = newsId.value;
    const method = id ? 'PUT' : 'POST';
    const body = new URLSearchParams({ id, title: newsTitle.value, body: newsBody.value });

    const res = await fetch(apiEndpoint, { method, body });
    const data = await res.json();
    if (data.success) {
        newsId.value = '';
        newsTitle.value = '';
        newsBody.value = '';
        fetchNews();
    } else {
        alert(data.message || 'An error occurred.');
    }
});

window.editNews = (id, title, body) => {
    newsId.value = id;
    newsTitle.value = title;
    newsBody.value = body;
};

window.deleteNews = async id => {
    if (!confirm('Are you sure?')) return;
    const res = await fetch(apiEndpoint, {
        method: 'DELETE',
        body: new URLSearchParams({ id })
    });
    const data = await res.json();
    if (data.success) {
        if (newsId.value == id) {
            newsId.value = '';
            newsTitle.value = '';
            newsBody.value = '';
        }
        fetchNews();
    } else {
        alert(data.message || 'Delete failed.');
    }
};

fetchNews();
