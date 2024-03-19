use candid::CandidType;
use std::collections::HashMap;
use serde::{Deserialize};

#[derive(CandidType, Deserialize)]
struct Transaction {
    from_account: String,
    to_account: String,
    amount: f64,
}

#[derive(CandidType, Deserialize, Clone)]
struct Account {
    balance: f64,
}

#[derive(CandidType)]
struct TransactionManager {
    accounts: HashMap<String, Account>,
}

impl TransactionManager {
    fn new() -> Self {
        TransactionManager {
            accounts: HashMap::new(),
        }
    }
    
    fn add_account(&mut self, account_id: String, initial_balance: f64) -> String {
        if self.accounts.contains_key(&account_id) {
            return format!("Account {} already exists", account_id);
        }
    
        self.accounts.insert(account_id.clone(), Account { balance: initial_balance });
        format!("Account {} added successfully", account_id)
    }    
    
    fn remove_account(&mut self, account_id: &str) -> Option<Account> {
        self.accounts.remove(account_id)
    }
    
    fn deposit(&mut self, account_id: &str, amount: f64) -> String {
        match self.accounts.get_mut(account_id) {
            Some(account) => {
                account.balance += amount;
                format!("Deposit successful. New balance: {}", account.balance)
            }
            None => format!("Account {} not found", account_id),
        }
    }
    
    fn withdraw(&mut self, account_id: &str, amount: f64) -> String {
        match self.accounts.get_mut(account_id) {
            Some(account) => {
                if account.balance >= amount {
                    account.balance -= amount;
                    format!("Withdrawal successful. New balance: {}", account.balance)
                } else {
                    format!("Insufficient balance in account {}", account_id)
                }
            }
            None => format!("Account {} not found", account_id),
        }
    }
    
    fn transfer(&mut self, from_account_id: &str, to_account_id: &str, amount: f64) -> String {
        if let Some(mut from_account) = self.accounts.get_mut(from_account_id).cloned() {
            if let Some(mut to_account) = self.accounts.get_mut(to_account_id) {
                if from_account.balance >= amount {
                    from_account.balance -= amount;
                    to_account.balance += amount;
                    return format!(
                        "Transfer successful from {} to {}. New balance for {} is {} and for {} is {}",
                        from_account_id,
                        to_account_id,
                        from_account_id,
                        from_account.balance,
                        to_account_id,
                        to_account.balance
                    );
                } else {
                    return format!("Insufficient balance in account {}", from_account_id);
                }
            }
        }
        "Failed to perform transfer".to_string()
    }
    
    fn get_balance(&self, account_id: &str) -> String {
        match self.accounts.get(account_id) {
            Some(account) => format!("Balance for account {}: {}", account_id, account.balance),
            None => format!("Account {} not found", account_id),
        }
    }
}

#[ic_cdk_macros::query]
fn add_account(account_id: String, initial_balance: f64) -> String {
    let mut manager = TransactionManager::new();
    manager.add_account(account_id, initial_balance)
}

#[ic_cdk_macros::query]
fn remove_account(account_id: String) -> Option<Account> {
    let mut manager = TransactionManager::new();
    manager.remove_account(&account_id)
}

#[ic_cdk_macros::query]
fn deposit(account_id: String, amount: f64) -> String {
    let mut manager = TransactionManager::new();
    manager.deposit(&account_id, amount)
}

#[ic_cdk_macros::query]
fn withdraw(account_id: String, amount: f64) -> String {
    let mut manager = TransactionManager::new();
    manager.withdraw(&account_id, amount)
}

#[ic_cdk_macros::query]
fn transfer(from_account_id: String, to_account_id: String, amount: f64) -> String {
    let mut manager = TransactionManager::new();
    manager.transfer(&from_account_id, &to_account_id, amount)
}

#[ic_cdk_macros::query]
fn get_balance(account_id: String) -> String {
    let manager = TransactionManager::new();
    manager.get_balance(&account_id)
}

// Enable Candid export
ic_cdk::export_candid!();
