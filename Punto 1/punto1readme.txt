Readme parcial punto 1
sudo yum update
yum install vim
sudo yum install -y epel-release
sudo yum install python3-pip 
pip3 install Flask
sudo yum install wget 
wget http://repo.mysql.com/mysql-community-release-el7-5.noarch.rpm
sudo rpm -ivh mysql-community-release-el7-5.noarch.rpm
sudo yum install mysql-server 
sudo yum install mysql-devel 
sudo yum install gcc -y
sudo yum install python3-devel 
pip3 install flask-mysqldb
sudo systemctl start mysqld
mysql -u root -p
CREATE DATABASE myflaskapp;
use myflaskapp;
CREATE TABLE books (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title varchar(255),
    description varchar(255),
    author varchar(255)
);
INSERT INTO books VALUES(null, "La hojarasca", "Interesante", "Gabo"),
    (null, "El principito", "Brillante", "Antoine de Saint");

vim apirest_mysql.py

#!flask/bin/python
from flask import Flask, jsonify
from flask import abort
from flask import request

from flask_mysqldb import MySQL

app = Flask(__name__)

# Config MySQL
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'myflaskapp'
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'

mysql = MySQL(app)

# Get all books
# For testing: curl -i http://localhost:5000/books
@app.route('/books', methods=['GET'])
def get_books():
    cur = mysql.connection.cursor()
    cur.execute("SELECT * from books")
    books = cur.fetchall()
    return jsonify({'books': books})

# Get one book by id
# For testing: curl -i http://localhost:5000/books/2
@app.route('/books/<int:book_id>', methods=['GET'])
def get_book(book_id):
    # book = [book for book in books if book['id'] == book_id]
    cur = mysql.connection.cursor()
    cur.execute("SELECT * from books WHERE id="+str(book_id))
    book = cur.fetchall()
    return jsonify({'book': book[0]})

# Add new book
# For testing: curl -i -H "Content-Type: application/json" -X POST -d '{"title":"El libro"}' http://localhost:5000/books
@app.route('/books', methods=['POST'])
def create_book():
    if not request.json or not 'title' in request.json:
        abort(400)
    title = request.json.get('title', "")
    description = request.json.get('description', "")
    author = request.json.get('author', "")
    cur = mysql.connection.cursor()
    cur.execute("INSERT INTO books(title,description,author) VALUES(%s,%s,%s)",(title,description,author))
    mysql.connection.commit()
    return jsonify({'book': request.json}), 201

# Edit a Book
# For testing: curl -i -H "Content-Type: application/json" -X PUT -d '{"author":"Jorgito"}' http://localhost:5000/books/2
@app.route('/books/<int:book_id>', methods=['PUT'])
def update_book(book_id):
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM books where id="+str(book_id))
    book = cur.fetchall()
    print(book[0])
    title = request.json.get('title', book[0]['title'])
    description = request.json.get('description', book[0]['description'])
    author = request.json.get('author', book[0]['author'])
    cur.execute("UPDATE books SET title =%s, description =%s ,author= %s WHERE id=%s",(title,description,author,book_id))
    mysql.connection.commit()
    return jsonify({'book': book[0]})

# Delete a Book
# For testing: curl -i -H "Content-Type: application/json" -X DELETE http://localhost:5000/books/1
@app.route('/books/<int:book_id>', methods=['DELETE'])
def delete_book(book_id):
    cur = mysql.connection.cursor()
    cur.execute("DELETE FROM books WHERE id="+str(book_id))
    mysql.connection.commit()
    return jsonify({'result': True})
    
if __name__ == '__main__':
    app.run(debug=True)

export FLASK_APP=apirest_mysql.py
python3 -m flask run --host=0.0.0.0

Instalar localmente xxamp
Creamos una carpeta en la siguiente ruta dentro de nuestra maquina fisica
C:\xampp\htdocs\punto1parcialfinal
Copiamos el archivo php del repositorio de git
phphtmlbooks
Abrimos el panel de xxamp
Damos start al service de appache
Entramos al navegador a la ruta 
http://localhost/punto1parcialfinal/
Damos click en el link subrrallado de phphtmllibrary.php
Ahora aparecera la interfas API REST + MYSQL
