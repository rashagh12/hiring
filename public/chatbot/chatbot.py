from flask import Flask, request, jsonify
import pickle
import logging
import numpy as np

app = Flask(__name__)

# Configure logging
logging.basicConfig(level=logging.INFO)

# Load the model and vectorizer
try:
    with open('tfidf.pkl', 'rb') as file:
        vectorizer = pickle.load(file)
    with open('clf.pkl', 'rb') as file:
        model = pickle.load(file)
except Exception as e:
    app.logger.error(f"Error loading model or vectorizer: {e}")

@app.route('/chat', methods=['POST'])
def chat():
    try:
        data = request.get_json()
        message = data.get('message', '')

        if message is None or not isinstance(message, str):
            raise ValueError("Invalid input: message is None or not a string")

        # Convert the message to lower case
        message = message.lower()

        # Vectorize the input message
        message_vector = vectorizer.transform([message])

        # Predict the response using the model
        response = model.predict(message_vector)

        # Convert the response to a JSON serializable type
        response = response[0].item() if isinstance(response[0], np.generic) else response[0]

        return jsonify({'response': response})
    except Exception as e:
        app.logger.error(f"Error processing chat request: {e}")
        return jsonify({'error': 'Internal server error'}), 500

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
