const MyApp = {
    articles: [
        { title: "Innovations in AI", authors: "Jane Doe", doi: "10.5678/ai001", views: { abstract: 120, fulltext: 60 }, pages: "1-15", pdfLink: "path/to/ai001.pdf" },
        { title: "The Future of Quantum Computing", authors: "John Smith", doi: "10.5678/qc002", views: { abstract: 95, fulltext: 45 }, pages: "16-30", pdfLink: "path/to/qc002.pdf" },
        { title: "Advances in Machine Learning", authors: "Alice Johnson", doi: "10.5678/ml003", views: { abstract: 110, fulltext: 70 }, pages: "31-45", pdfLink: "path/to/ml003.pdf" },
        { title: "Exploring the Universe", authors: "Bob Brown", doi: "10.5678/universe004", views: { abstract: 130, fulltext: 80 }, pages: "46-60", pdfLink: "path/to/universe004.pdf" },
        { title: "The Role of Big Data in Healthcare", authors: "Eve Davis", doi: "10.5678/bd005", views: { abstract: 140, fulltext: 90 }, pages: "61-75", pdfLink: "path/to/bd005.pdf" },
        { title: "Cybersecurity Trends 2024", authors: "Charlie Wilson", doi: "10.5678/cyber006", views: { abstract: 105, fulltext: 55 }, pages: "76-90", pdfLink: "path/to/cyber006.pdf" },
        { title: "Climate Change and Its Impact", authors: "Olivia Martinez", doi: "10.5678/climate007", views: { abstract: 120, fulltext: 65 }, pages: "91-105", pdfLink: "path/to/climate007.pdf" },
        { title: "Blockchain Technology Explained", authors: "Liam Anderson", doi: "10.5678/blockchain008", views: { abstract: 95, fulltext: 50 }, pages: "106-120", pdfLink: "path/to/blockchain008.pdf" },
        { title: "Ethical AI Practices", authors: "Sophia Taylor", doi: "10.5678/ethics009", views: { abstract: 110, fulltext: 75 }, pages: "121-135", pdfLink: "path/to/ethics009.pdf" },
        { title: "Modern Web Development Trends", authors: "James Lee", doi: "10.5678/web010", views: { abstract: 125, fulltext: 85 }, pages: "136-150", pdfLink: "path/to/web010.pdf" },
        // Tambahkan lebih banyak artikel jika perlu
    ]
};

let currentPage = 1;
const itemsPerPage = 5;
const totalPages = Math.ceil(MyApp.articles.length / itemsPerPage);

function displayArticles(page) {
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedArticles = MyApp.articles.slice(start, end);
    const articlesList = document.getElementById('articles-list');

    articlesList.innerHTML = '';

    paginatedArticles.forEach(article => {
        const articleItem = document.createElement('li');
        articleItem.innerHTML = `
            <strong><a href="${article.pdfLink}">${article.title}</a></strong>
            <br>${article.authors}
            <br> DOI: <a href="https://doi.org/${article.doi}" target="_blank">${article.doi}</a>
            <br> Abstract views: ${article.views.abstract} | Fulltext views: ${article.views.fulltext}
            <br> <a href="${article.pdfLink}" download>Download PDF</a>
            <br> Pages: ${article.pages}
        `;
        articlesList.appendChild(articleItem);
    });

    updatePagination(page);
}

function updatePagination(currentPage) {
    const paginationLinks = document.querySelectorAll('.pagination ul li');
    paginationLinks.forEach(link => {
        link.classList.remove('active');
        if (parseInt(link.getAttribute('value')) === currentPage) {
            link.classList.add('active');
        }
    });

    const pageInfo = document.getElementById('page-info');
    if (pageInfo) {
        pageInfo.innerText = `Page ${currentPage} of ${totalPages}`;
    }
}

function activeLink(event) {
    const page = parseInt(event.target.getAttribute('value'));
    currentPage = page;
    displayArticles(currentPage);
}

function backBtn() {
    if (currentPage > 1) {
        currentPage--;
        displayArticles(currentPage);
    }
}

function nextBtn() {
    if (currentPage < totalPages) {
        currentPage++;
        displayArticles(currentPage);
    }
}

// Generate pagination links dynamically based on total pages
function generatePaginationLinks() {
    const paginationList = document.querySelector('.pagination ul');
    paginationList.innerHTML = '';  // Kosongkan pagination list

    for (let i = 1; i <= totalPages; i++) {
        const pageLink = document.createElement('li');
        pageLink.classList.add('link');
        if (i === 1) pageLink.classList.add('active');
        pageLink.setAttribute('value', i);
        pageLink.textContent = i;
        pageLink.addEventListener('click', activeLink);
        paginationList.appendChild(pageLink);
    }
}

// Generate pagination links on page load
generatePaginationLinks();

// Tampilkan halaman pertama ketika halaman dimuat
displayArticles(currentPage);
