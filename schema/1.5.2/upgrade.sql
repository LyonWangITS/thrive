-- Update phone number, 352-214-4047 -> 352-562-6495
UPDATE `services` SET
  `contact_numbers` = "352-562-6495",
  `additional_info` = "Any questions or interested in additional referrals? Call us at 352-562-6495 or email us at anchorsresearch@hhp.ufl.edu. If you call, you do not need to give your name."
  WHERE `contact_numbers` = "352-214-4047";
