// Get DOM elements
const searchInput = document.getElementById('search');
const [visibleArticlesContainer, hiddenArticlesContainer] = document.querySelectorAll('.articles-container');

// Actual search logic
function searchArticles(articlesContainer, term, tags){

    `
        <a class="article-card hidden" href="{{ path('article', {id: article.id}) }}">
            <p class="article-card-date">{{ article.dateCreated | date('d/m/Y') }}</p>
            <p class="article-card-title">{{ article.title }}</p>
            <p class="article-card-subtitle">{{ article.subtitle }}</p>
        </a>
    `

    const articles = articlesContainer.querySelectorAll('.article-card');
    for (const article of articles) {

        // Check if article title contains terms
        const title = article.querySelector('.article-card-title').textContent.toLowerCase();
        const subtitle = article.querySelector('.article-card-subtitle').textContent.toLowerCase();
        
        if (!title.includes(term) && !subtitle.includes(term)) {
            article.hidden = true;
            continue;
        }

        // Get the list of tags
        const articleTags = Array.from(article.querySelectorAll('.article-card-tag')).map(tag => tag.textContent.toLowerCase());
        if (tags.length > 0 && !tags.some(tag => articleTags.includes(tag))) {
            article.hidden = true;
            continue;
        }

        // Everything matches, show the article
        article.hidden = false;

    }

}

// Handle search request
function handleSearchRequest() {
    const searchTerm = searchInput.value.toLowerCase();
    const tags = [];
    searchArticles(visibleArticlesContainer, searchTerm, tags);
    if (hiddenArticlesContainer) searchArticles(hiddenArticlesContainer, searchTerm, tags);
}

// Bind inputs
searchInput.onchange = handleSearchRequest;
