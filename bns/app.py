from flask import Flask, render_template, request, jsonify
from sections_datapart1 import sections_datapart1
from sections_datapart2 import sections_datapart2

app = Flask(__name__)

sections_data = sections_datapart1 + sections_datapart2

@app.route("/")
def home():
    return render_template("index.html")

@app.route("/search")
def search():
    query = request.args.get('query', '').lower()
    results = [section for section in sections_data if query in str(section['section_number']).lower() or query in section['title'].lower()]
    return jsonify(results)

if __name__ == "__main__":
    app.run(debug=True)