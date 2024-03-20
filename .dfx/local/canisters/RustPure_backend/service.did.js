export const idlFactory = ({ IDL }) => {
  return IDL.Service({
    'add_account' : IDL.Func([IDL.Text, IDL.Float64], [IDL.Text], ['query']),
    'deposit' : IDL.Func([IDL.Text, IDL.Float64], [IDL.Text], ['query']),
    'get_balance' : IDL.Func([IDL.Text], [IDL.Text], ['query']),
    'remove_account' : IDL.Func([IDL.Text], [IDL.Text], ['query']),
    'transfer' : IDL.Func(
        [IDL.Text, IDL.Text, IDL.Float64],
        [IDL.Text],
        ['query'],
      ),
    'withdraw' : IDL.Func([IDL.Text, IDL.Float64], [IDL.Text], ['query']),
  });
};
export const init = ({ IDL }) => { return []; };
