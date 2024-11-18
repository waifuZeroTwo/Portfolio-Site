document.querySelectorAll('.tag-filter').forEach(tag => {
    tag.addEventListener('click', e => {
        e.preventDefault();
        document.querySelectorAll('.project').forEach(project => {
            if (!project.classList.contains(`tag-${e.target.dataset.tagId}`)) {
                project.style.display = 'none';
            } else {
                project.style.display = 'block';
            }
        });
    });
});
