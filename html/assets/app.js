const initQuizProgress = () => {
  const form = document.querySelector('#quiz-form');
  if (!form) {
    return;
  }

  const questions = Array.from(form.querySelectorAll('.question'));
  const progressLabel = document.querySelector('[data-progress]');
  const total = questions.length;

  const updateProgress = () => {
    const answered = questions.filter((question) => question.querySelector('input:checked')).length;
    if (progressLabel) {
      progressLabel.textContent = `${answered} / ${total} answered`;
    }
  };

  form.addEventListener('change', updateProgress);

  form.addEventListener('submit', (event) => {
    const unanswered = questions.filter((question) => !question.querySelector('input:checked'));
    if (unanswered.length > 0) {
      event.preventDefault();
      const first = unanswered[0];
      first.scrollIntoView({ behavior: 'smooth', block: 'center' });
      first.classList.add('shake');
      setTimeout(() => first.classList.remove('shake'), 600);
    }
  });

  updateProgress();
};

window.addEventListener('DOMContentLoaded', initQuizProgress);
