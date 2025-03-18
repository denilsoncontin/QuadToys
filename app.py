from flask import Flask, render_template, request, redirect, url_for
from models.cliente import Cliente
from models.produto import Produto
from models.carrinho import Carrinho
from models.pedido import Pedido
import mysql.connector

app = Flask(__name__)

# Configuração do banco de dados
db_config = {
    'host': '127.0.0.1',
    'user': 'root',
    'password': '',
    'database': 'colecionaveis'
}

def get_db_connection():
    conn = mysql.connector.connect(**db_config)
    return conn

@app.route('/')
def index():
    conn = get_db_connection()
    cursor = conn.cursor(dictionary=True)
    cursor.execute('SELECT * FROM produtos WHERE destaque = 1')
    produtos_destaque = cursor.fetchall()
    cursor.close()
    conn.close()
    return render_template('index.html', produtos=produtos_destaque)

@app.route('/produto/<int:produto_id>')
def produto(produto_id):
    conn = get_db_connection()
    cursor = conn.cursor(dictionary=True)
    cursor.execute('SELECT * FROM produtos WHERE produto_id = %s', (produto_id,))
    produto = cursor.fetchone()
    cursor.close()
    conn.close()
    return render_template('product.html', produto=produto)

@app.route('/carrinho')
def carrinho():
    # Lógica para exibir o carrinho de compras
    return render_template('cart.html')

if __name__ == '__main__':
    app.run(debug=True)