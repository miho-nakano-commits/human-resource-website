const CONTACT_EMAIL = 'CONTACT_EMAIL_HERE';

const contactForm = document.querySelector('[data-contact-form]');

if (contactForm) {
  const status = contactForm.querySelector('[data-form-status]');
  const submitButton = contactForm.querySelector('button[type="submit"]');

  const setStatus = (message, type = '') => {
    status.textContent = message;
    status.classList.remove('is-error', 'is-success');
    if (type) {
      status.classList.add(type);
    }
  };

  contactForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    if (!contactForm.checkValidity()) {
      contactForm.classList.add('is-validated');
      contactForm.reportValidity();
      setStatus('必須項目をご入力ください。', 'is-error');
      return;
    }

    if (!CONTACT_EMAIL || CONTACT_EMAIL === 'CONTACT_EMAIL_HERE') {
      setStatus('送信先メールアドレスの設定後に送信できます。', 'is-error');
      return;
    }

    const formData = new FormData(contactForm);
    const payload = Object.fromEntries(formData.entries());

    submitButton.disabled = true;
    submitButton.textContent = '送信中...';
    setStatus('');

    try {
      const response = await fetch(`https://formsubmit.co/ajax/${CONTACT_EMAIL}`, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
      });

      if (!response.ok) {
        throw new Error('Failed to send inquiry.');
      }

      contactForm.reset();
      contactForm.classList.remove('is-validated');
      setStatus('送信が完了しました。お問い合わせありがとうございます。', 'is-success');
    } catch (error) {
      setStatus('送信できませんでした。時間をおいて再度お試しください。', 'is-error');
    } finally {
      submitButton.disabled = false;
      submitButton.textContent = '送信する';
    }
  });
}
