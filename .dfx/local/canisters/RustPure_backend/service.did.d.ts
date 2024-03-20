import type { Principal } from '@dfinity/principal';
import type { ActorMethod } from '@dfinity/agent';
import type { IDL } from '@dfinity/candid';

export interface _SERVICE {
  'add_account' : ActorMethod<[string, number], string>,
  'deposit' : ActorMethod<[string, number], string>,
  'get_balance' : ActorMethod<[string], string>,
  'remove_account' : ActorMethod<[string], string>,
  'transfer' : ActorMethod<[string, string, number], string>,
  'withdraw' : ActorMethod<[string, number], string>,
}
export declare const idlFactory: IDL.InterfaceFactory;
export declare const init: (args: { IDL: typeof IDL }) => IDL.Type[];
