import subprocess
from flask import Flask, request, jsonify
canister_id = 'RustPure_backend'
app = Flask(__name__)

@app.route('/deposit_icp', methods=['GET'])
def deposit_icp():
    account_id = request.args.get('to')
    amount = request.args.get('amount')
    
    if not account_id or not amount:
        return jsonify({'error': 'Missing "account_id" or "amount" parameter'}), 400
    
    # Call dfx command to perform ICP deposit
    cmd = f'dfx canister call {canister_id} deposit \'("{account_id}", {amount})\''
    try:
        result = subprocess.check_output(cmd, shell=True)
        # Decode the result from bytes to string
        result_str = result.decode('utf-8')
        # Return the result to the frontend
        return jsonify({'success': True, 'message': result_str}), 200
    except subprocess.CalledProcessError as e:
        return jsonify({'error': f'Failed to deposit ICP: {e.output.decode("utf-8")}'}), 500

@app.route('/withdraw_icp', methods=['GET'])
def withdraw_icp():
    account_id = request.args.get('to')
    amount = request.args.get('amount')
    
    if not account_id or not amount:
        return jsonify({'error': 'Missing "account_id" or "amount" parameter'}), 400
    
    # Call dfx command to perform ICP withdrawal
    cmd = f'dfx canister call {canister_id} withdraw \'("{account_id}", {amount})\''
    try:
        result = subprocess.check_output(cmd, shell=True)
        # Decode the result from bytes to string
        result_str = result.decode('utf-8')
        # Return the result to the frontend
        return jsonify({'success': True, 'message': result_str}), 200
    except subprocess.CalledProcessError as e:
        return jsonify({'error': f'Failed to withdraw ICP: {e.output.decode("utf-8")}'}), 500

@app.route('/transfer_icp', methods=['GET'])
def transfer_icp():
    from_account_id = request.args.get('from')
    to_account_id = request.args.get('to')
    amount = request.args.get('amount')
    
    if not from_account_id or not to_account_id or not amount:
        return jsonify({'error': 'Missing "from_account_id", "to_account_id", or "amount" parameter'}), 400
    
    # Call dfx command to perform ICP transfer
    cmd = f'dfx canister call {canister_id} transfer \'("{from_account_id}", "{to_account_id}", {amount})\''
    try:
        result = subprocess.check_output(cmd, shell=True)
        # Decode the result from bytes to string
        result_str = result.decode('utf-8')
        # Return the result to the frontend
        return jsonify({'success': True, 'message': result_str}), 200
    except subprocess.CalledProcessError as e:
        return jsonify({'error': f'Failed to transfer ICP: {e.output.decode("utf-8")}'}), 500

@app.route('/get_balance', methods=['GET'])
def get_balance():
    account_id = request.args.get('account_id')
    
    if not account_id:
        return jsonify({'error': 'Missing "account_id" parameter'}), 400
    
    # Call dfx command to get account balance
    cmd = f'dfx canister call {canister_id} get_balance \'{account_id}\''
    try:
        result = subprocess.check_output(cmd, shell=True)
        # Decode the result from bytes to string
        result_str = result.decode('utf-8')
        # Return the result to the frontend
        return jsonify({'success': True, 'balance': result_str}), 200
    except subprocess.CalledProcessError as e:
        return jsonify({'error': f'Failed to get balance: {e.output.decode("utf-8")}'}), 500

if __name__ == '__main__':
    app.run(debug=True)
