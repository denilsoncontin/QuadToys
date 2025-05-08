<?php
include 'includes/header.php';
?>

<div class="container">
    <div class="comunidade-container">
        <div class="page-header">
            <h1>Comunidade QuadToys</h1>
            <p>Conecte-se com outros colecionadores, participe de eventos e fique por dentro das novidades!</p>
        </div>
        
        <div class="comunidades-grid">
            <div class="comunidade-card">
                <div class="comunidade-img">
                    <img src="img/comunidade/quadmania.jpg" alt="QuadMania">
                </div>
                <div class="comunidade-info">
                    <h3>QuadMania</h3>
                    <p>O maior grupo de colecionadores de quadrinhos do Brasil. Troque, venda e compre itens raros.</p>
                    <p class="comunidade-membros">2.500+ membros</p>
                    <a href="https://facebook.com/groups/quadmania" target="_blank" class="btn-join">Participar</a>
                </div>
            </div>
            
            <div class="comunidade-card">
                <div class="comunidade-img">
                    <img src="img/comunidade/action-collectors.jpg" alt="Action Collectors">
                </div>
                <div class="comunidade-info">
                    <h3>Action Collectors</h3>
                    <p>Comunidade especializada em action figures de todos os universos. Compartilhe sua coleção!</p>
                    <p class="comunidade-membros">1.800+ membros</p>
                    <a href="https://discord.gg/actioncollectors" target="_blank" class="btn-join">Entrar no Discord</a>
                </div>
            </div>
            
            <div class="comunidade-card">
                <div class="comunidade-img">
                    <img src="img/comunidade/tokusatsu-br.jpg" alt="Tokusatsu Brasil">
                </div>
                <div class="comunidade-info">
                    <h3>Tokusatsu Brasil</h3>
                    <p>Dedicado aos fãs de séries japonesas como Ultraman, Kamen Rider e Super Sentai.</p>
                    <p class="comunidade-membros">1.200+ membros</p>
                    <a href="https://telegram.org/tokusatsu-br" target="_blank" class="btn-join">Entrar no Telegram</a>
                </div>
            </div>
            
            <div class="comunidade-card">
                <div class="comunidade-img">
                    <img src="img/comunidade/quadtoys-clube.jpg" alt="QuadToys Clube">
                </div>
                <div class="comunidade-info">
                    <h3>QuadToys Clube</h3>
                    <p>Grupo oficial da QuadToys. Seja o primeiro a saber sobre novidades, promoções exclusivas e eventos.</p>
                    <p class="comunidade-membros">3.200+ membros</p>
                    <a href="https://instagram.com/quadtoysclube" target="_blank" class="btn-join">Seguir no Instagram</a>
                </div>
            </div>
        </div>
        
        <div class="eventos-section">
            <h2>Próximos Eventos</h2>
            
            <div class="eventos-list">
                <div class="evento-card">
                    <div class="evento-data">
                        <span class="dia">15</span>
                        <span class="mes">Jun</span>
                    </div>
                    <div class="evento-info">
                        <h3>Encontro de Colecionadores QuadToys</h3>
                        <p class="evento-local">Shopping Center Norte - São Paulo, SP</p>
                        <p>O maior encontro de colecionadores do Brasil! Traga sua coleção, troque itens e participe de palestras com ilustradores famosos.</p>
                        <a href="#" class="btn-evento">Saiba mais</a>
                    </div>
                </div>
                
                <div class="evento-card">
                    <div class="evento-data">
                        <span class="dia">22</span>
                        <span class="mes">Jul</span>
                    </div>
                    <div class="evento-info">
                        <h3>Comic-Con QuadToys</h3>
                        <p class="evento-local">Expo Center Norte - São Paulo, SP</p>
                        <p>Evento especial com lançamentos exclusivos, sessões de autógrafos e muito mais!</p>
                        <a href="#" class="btn-evento">Saiba mais</a>
                    </div>
                </div>
                
                <div class="evento-card">
                    <div class="evento-data">
                        <span class="dia">10</span>
                        <span class="mes">Ago</span>
                    </div>
                    <div class="evento-info">
                        <h3>Workshop: Conservação de Quadrinhos</h3>
                        <p class="evento-local">Online - Transmissão ao vivo</p>
                        <p>Aprenda técnicas profissionais para preservar suas revistas em quadrinhos e aumentar seu valor.</p>
                        <a href="#" class="btn-evento">Inscreva-se</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="forum-section">
            <h2>Fórum da Comunidade</h2>
            <p class="forum-intro">Participe das discussões no nosso fórum oficial. Compartilhe conhecimento, faça perguntas e conecte-se com outros colecionadores.</p>
            
            <div class="forum-topics">
                <div class="topic-card">
                    <h3>Quadrinhos Raros dos Anos 80</h3>
                    <p class="topic-stats">32 respostas • Última atividade: hoje</p>
                    <a href="#" class="btn-topic">Ver discussão</a>
                </div>
                
                <div class="topic-card">
                    <h3>Guia de Iniciantes: Como montar sua primeira coleção</h3>
                    <p class="topic-stats">78 respostas • Última atividade: ontem</p>
                    <a href="#" class="btn-topic">Ver discussão</a>
                </div>
                
                <div class="topic-card">
                    <h3>Marvel vs DC: A batalha eterna dos colecionadores</h3>
                    <p class="topic-stats">105 respostas • Última atividade: 2 dias atrás</p>
                    <a href="#" class="btn-topic">Ver discussão</a>
                </div>
                
                <div class="topic-card">
                    <h3>Como identificar Action Figures falsificadas</h3>
                    <p class="topic-stats">43 respostas • Última atividade: 3 dias atrás</p>
                    <a href="#" class="btn-topic">Ver discussão</a>
                </div>
            </div>
            
            <a href="#" class="btn-all-topics">Ver todos os tópicos</a>
        </div>
    </div>
</div>

<style>
    .comunidade-container {
        padding: 40px 0;
    }
    .page-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .page-header h1 {
        font-size: 2.5em;
        color: #333;
        margin-bottom: 15px;
    }
    .page-header p {
        font-size: 1.1em;
        color: #666;
        max-width: 700px;
        margin: 0 auto;
    }
    
    /* Estilos para as comunidades */
    .comunidades-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
    }
    .comunidade-card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .comunidade-card:hover {
        transform: translateY(-5px);
    }
    .comunidade-img {
        height: 160px;
        background-color: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .comunidade-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .comunidade-info {
        padding: 20px;
    }
    .comunidade-info h3 {
        margin-top: 0;
        font-size: 1.4em;
        color: #333;
        margin-bottom: 10px;
    }
    .comunidade-info p {
        color: #666;
        margin-bottom: 15px;
        line-height: 1.5;
    }
    .comunidade-membros {
        color: #4CAF50 !important;
        font-weight: bold;
        font-size: 0.9em;
    }
    .btn-join {
        display: inline-block;
        background-color: #4CAF50;
        color: white;
        padding: 8px 20px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s;
    }
    .btn-join:hover {
        background-color: #45a049;
    }
    
    /* Estilos para os eventos */
    .eventos-section {
        margin-bottom: 60px;
    }
    .eventos-section h2 {
        font-size: 2em;
        color: #333;
        margin-bottom: 30px;
        text-align: center;
    }
    .eventos-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .evento-card {
        display: flex;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .evento-data {
        background-color: #4CAF50;
        color: white;
        padding: 15px;
        min-width: 80px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .evento-data .dia {
        font-size: 1.8em;
        font-weight: bold;
    }
    .evento-data .mes {
        font-size: 1em;
        text-transform: uppercase;
    }
    .evento-info {
        padding: 20px;
        flex-grow: 1;
    }
    .evento-info h3 {
        margin-top: 0;
        font-size: 1.3em;
        color: #333;
        margin-bottom: 5px;
    }
    .evento-local {
        color: #777;
        font-style: italic;
        margin-bottom: 10px;
    }
    .btn-evento {
        display: inline-block;
        background-color: #f0f0f0;
        color: #333;
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        margin-top: 10px;
        transition: background-color 0.3s;
    }
    .btn-evento:hover {
        background-color: #e0e0e0;
    }
    
    /* Estilos para o fórum */
    .forum-section {
        margin-bottom: 40px;
    }
    .forum-section h2 {
        font-size: 2em;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }
    .forum-intro {
        text-align: center;
        color: #666;
        max-width: 800px;
        margin: 0 auto 40px;
    }
    .forum-topics {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .topic-card {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        padding: 20px;
        transition: transform 0.3s ease;
    }
    .topic-card:hover {
        transform: translateY(-3px);
    }
    .topic-card h3 {
        margin-top: 0;
        font-size: 1.2em;
        color: #333;
        margin-bottom: 10px;
    }
    .topic-stats {
        color: #777;
        font-size: 0.9em;
        margin-bottom: 15px;
    }
    .btn-topic {
        display: inline-block;
        background-color: #f0f0f0;
        color: #333;
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s;
    }
    .btn-topic:hover {
        background-color: #e0e0e0;
    }
    .btn-all-topics {
        display: block;
        width: 200px;
        background-color: #4CAF50;
        color: white;
        padding: 10px 0;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        text-align: center;
        margin: 0 auto;
        transition: background-color 0.3s;
    }
    .btn-all-topics:hover {
        background-color: #45a049;
    }
</style>

<?php include 'includes/footer.php'; ?>