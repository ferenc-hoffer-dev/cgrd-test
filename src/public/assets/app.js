const newsList = document.getElementById('newsList');
const newsForm = document.getElementById('newsForm');
const newsId = document.getElementById('newsId');
const newsTitle = document.getElementById('newsTitle');
const newsBody = document.getElementById('newsBody');
const formHeader = document.getElementById('formHeader');
const newsHeader = document.getElementById('newsHeader');
const apiEndpoint = '/api.php';

let newsData = [];

const renderNewsList = items => {
    newsList.innerHTML = '';

    if (items.length === 0) {
        newsHeader.style.display = 'none';
        return;
    } else {
        newsHeader.style.display = 'block';
    }

    items.forEach(item => {
        const li = document.createElement('li');
        li.classList.add('news-item');
        li.dataset.id = item.id;
        li.innerHTML = `
            <div class="news-content">
                <span class="news-title">${item.title}</span>
                <span class="news-body">${item.body}</span>
            </div>
            <div class="news-actions">
                <img src="assets/pencil.svg" alt="Edit" class="edit-icon" data-id="${item.id}">
                <img src="assets/close.svg" alt="Delete" class="delete-icon" data-id="${item.id}">
            </div>
        `;
        newsList.appendChild(li);
    });
};

const resetForm = () => {
    newsId.value = '';
    newsTitle.value = '';
    newsBody.value = '';
    formHeader.textContent = 'Create News';
};

const fetchNews = async () => {
    try {
        const res = await fetch(apiEndpoint, { method: 'GET' });
        const data = await res.json();
        if (data.success) {
            newsData = data.data;
            renderNewsList(newsData);
        } else {
            console.error(data.message);
            alert('Error fetching news: ' + data.message);
        }
    } catch (error) {
        console.error('Fetch error:', error);
        alert('Could not connect to the server.');
    }
};

const editNews = id => {
    const newsItem = newsData.find(item => item.id == id);
    if (!newsItem) {
        alert('News item not found.');
        return;
    }
    newsId.value = newsItem.id;
    newsTitle.value = newsItem.title;
    newsBody.value = newsItem.body;
    formHeader.textContent = 'Edit News';
};

const deleteNews = async id => {
    if (!confirm('Are you sure you want to delete this news item?')) return;
    try {
        const res = await fetch(apiEndpoint, {
            method: 'DELETE',
            body: new URLSearchParams({ id })
        });
        const data = await res.json();
        if (data.success) {
            if (newsId.value == id) resetForm();
            fetchNews();
        } else {
            alert(data.message || 'Delete failed.');
        }
    } catch (error) {
        console.error('Delete error:', error);
        alert('Failed to delete the news item.');
    }
};

newsForm.addEventListener('submit', async e => {
    e.preventDefault();
    const id = newsId.value;
    const method = id ? 'PUT' : 'POST';
    const body = new URLSearchParams({ id, title: newsTitle.value, body: newsBody.value });

    try {
        const res = await fetch(apiEndpoint, { method, body });
        const data = await res.json();
        if (data.success) {
            resetForm();
            fetchNews();
        } else {
            alert(data.message || 'An error occurred.');
        }
    } catch (error) {
        console.error('Submit error:', error);
        alert('Failed to save the news item. Please check your connection.');
    }
});

newsList.addEventListener('click', e => {
    const target = e.target.closest('.edit-icon, .delete-icon');
    if (!target) return;

    const id = target.dataset.id;
    if (target.classList.contains('edit-icon')) {
        editNews(id);
    } else if (target.classList.contains('delete-icon')) {
        deleteNews(id);
    }
});

fetchNews();
