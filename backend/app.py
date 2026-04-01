from flask import Flask # 1. Traemos la herramienta Flask
app = Flask(__name__) # 2. Creamos la aplicación
@app.route('/') # 3. Decimos: "Cuando alguien entre a la página principal..."
def home(): # 4. "...ejecutá esta función"
return "<h1>¡Proyecto EEST 1 Funcionando!</h1>" # 5. Mostrá este título en pantalla
if __name__ == '__main__': # 6. Si este es el archivo principal...
app.run(debug=True) # 7. ¡Encendé el servidor! (debug=True sirve para ver errores)