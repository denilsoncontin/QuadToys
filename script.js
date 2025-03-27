

document.addEventListener('DOMContentLoaded', function() {
    // Simular carregamento de imagens (para demonstração)
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover';
    });
    
    // Adicionar efeito de hover nos botões
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseover', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.3s';
        });
        button.addEventListener('mouseout', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Simulação de contador de interessados
    const interessados = document.querySelectorAll('.meta span:last-child');
    interessados.forEach(span => {
        const currentValue = parseInt(span.textContent);
        // Aleatoriamente incrementa alguns contadores para simular interesse
        if (Math.random() > 0.7) {
            const newValue = currentValue + 1;
            span.textContent = `${newValue} Interessados`;
            span.style.color = '#e74c3c';
            setTimeout(() => {
                span.style.color = '#7f8c8d';
            }, 2000);
        }
    });
});