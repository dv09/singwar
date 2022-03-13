<?php

namespace App\Constants;

class SignWarCommandsConstans
{
    const TO_PLAY_OPTION = "toPlay";
    const TO_WIN_OPTION = "toWin";

    const TO_PLAY_INFO = "The game is to see who wins the trial. Enter the names of your winners and the signatories of their contract. For example \"KNN\" vs \"KNV\", who will win...?";
    const TO_WIN_INFO = "The game is to find the winning signature. For the signatures of your contract and we will give you the winner. For example \"KVN\" vs \"KN#\" .";

    const PLAY_DESCRIPTION = "  We are in the era of \"lawsuits\", everyone wants to go to court with their lawyer    \n
    Saul and try to get a lot of dollars as if they were raining over Manhattan.          \n
    The laws have changed much lately and governments have been digitized. That's when    \n
    Signaturit comes into play. The city council through the use of Signaturit maintains  \n
    a registry of legal signatures of each party involved in the contracts that are made. \n
    During a trial, justice only verifies the signatures of the parties involved in the   \n
    contract to decide who wins. For that, they assign points to the different signatures \n
    depending on the role of who signed. For example, if the plaintiff has a contract that\n 
    is signed by a notary he gets 2 points, if the defendant has in the contract the      \n
    signature of only a v alidator he gets only 1 point, so the plaintiff party wins the  \n
    trial.\n\n
    Roles King (K): 5 points.\n
    Notary (N): 2 points.\n
    Validator (V): 1 point.\n\n
    Keep in mind that when a King signs, the signatures of the validators on his part have no value.\n\n
    We have two game modes. Give us the names of the parties to your contract and the signatories\n
    who support it and we'll see who the winner is. On the other hand, give us a signature and an\n
    incomplete \"N#N\" and we will know how to complete it so that it is the winner.\n\n
    PLAY AND HAVE FUN";

    const TO_PLAY_COMMENT = ["Ready for the battle?", "We pass the names of your litigants", "and the signatures with their support", ", and we will see who wins!"];

    const PLAINTIFF_NAME = "Tell me the name of the plaintiff litigant: ";
    const DEFENDANT_NAME = "Tell me the name of the defendant litigant: ";

    const TO_PLAY_PLAINTIFF_SIGN = "Write the signature of the plaintiff litigant, something like this \"NKV\": ";
    const TO_PLAY_DEFENDANT_SIGN = "Write the signature of the defendant litigant, something like this \"NKV\": ";
    const TO_WIN_PLAINTIFF_SIGN = "Write the signature of the plaintiff litigant, something like this \"NKV\" or \"N#V\": ";
    const TO_WIN_DEFENDANT_SIGN = "Write the signature of the defendant litigant, something like this \"NKV\" or \"NK#\": ";


}