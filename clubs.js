document.addEventListener('DOMContentLoaded', function () {
    const clubs = [
        { id: 1, name: 'Gaming Guild', imageUrl: 'https://www.designmaroc.com/wp-content/uploads/2010/07/blackbox-3.jpg' },
        { id: 2, name: 'Fitness Fanatics', imageUrl: 'https://www.fitnessstory.fr/wp-content/uploads/2019/12/fitness-ou-musculation.jpg' },
        { id: 3, name: 'Bookworms Society', imageUrl: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTx1K-juQ4KJFpNTSNGvlx-6_rE2xM3nkc7pw&s' },
        { id: 4, name: 'Art Appreciation Club', imageUrl: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS6TeMrGn8RG4STXaip6X-HdgleHl-ljieHOA&s' },
        { id: 5, name: 'Music Melodies Club', imageUrl: 'https://www.digitalmusicnews.com/wp-content/uploads/2023/09/spotify-billions-club-to-hit-500-songs-before-apple-music-welcomes-its-first-article.png' }
    ];

    const clubSection = document.getElementById('clubSection');
    const clubInfo = document.getElementById('clubInfo');
    const clubImage = document.getElementById('clubImage');

    let currentClubIndex = 0;

    function displayClub(index) {
        const club = clubs[index];
        clubInfo.innerHTML = `<h3>${club.name}</h3>`;
        clubImage.innerHTML = `<img src="${club.imageUrl}" alt="${club.name}">`;
    }

    displayClub(currentClubIndex);

    // Optional: Add navigation buttons to switch between clubs
    const navButtons = document.createElement('div');
    navButtons.innerHTML = `
        <button id="prevClub" class="btn btn-primary">Previous</button>
        <button id="nextClub" class="btn btn-primary">Next</button>
    `;
    clubSection.appendChild(navButtons);

    document.getElementById('prevClub').addEventListener('click', () => {
        currentClubIndex = (currentClubIndex > 0) ? currentClubIndex - 1 : clubs.length - 1;
        displayClub(currentClubIndex);
    });

    document.getElementById('nextClub').addEventListener('click', () => {
        currentClubIndex = (currentClubIndex < clubs.length - 1) ? currentClubIndex + 1 : 0;
        displayClub(currentClubIndex);
    });
});
