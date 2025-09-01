# Longhair Records - Linode Users

## Server Maintenance

You should have received an invite to manage the Longhair Records server on the Linode dashboard. If you have not received an invite, let the admin (resonance.designs.com@gmail.com) know. All of the documentation below is for invited users. After you receive the invite and have set your password, you should be able to do all of the actions documented below.

### Creating account
ss
1. To create/activate your account, you will need to click the link in the email you received from Linode. You will be prompted to set a sassword for your account. Set your password and then you have successfully activated your account.
2. Log in to the Longhair Records server using the password you just set.
3. After logging in, click on the "Linodes" tab in the left sidebar.
4. You should see a list of "Linodes" after logging in. Specifically, there should be a "Linode" called "Ubuntu-22.04-Longhair-Prod". Click on it.

### Creating Backups

1. First, it is recommended that you shut down the Linode server before creating a backup. You can do this by clicking on the "Actions" button and then selecting "Power Off".
   * You can create a backup while the server is running but it highly suggested that you shut it down first. It is only recommended to create a backup while the server is running if there is a emergency situation where shutting down the server would cause a data loss or it is simply not possible to shut it down.
2. After it is powered off, you can create a backup by clicking on the "Backups" tab.
   * Once in the "Backups" tab, you will see a list of backups already created. Some backups are created automatically, and some are created manually. You can tell which are automatically created by the "Label" column. The label will display as "Automatic" if it was automatically created, and it will display as the label/title given during the process of creating the manual backup. For example, a backup with the label "Before Updates" will indicate that it was created manually.
   * To create a manual backup, you will see a section called "Manual Snapshot" below the list of backups. Simply type in the name of the backup you want to create and click the "Take Snapshot" button. The backup will be created and you will be notified when it is complete. You should be aware that any new manual backup will overwrite the previous. The account only allows one manual backup.
3. Once the backup is complete, you can power the server back on by clicking on the "Actions" button and then selecting "Power On".

### Restoring A Backup
s
1. Again, it is recommended that you shut down the Linode server before restoring a backup. You can do this by clicking on the "Actions" button and then selecting "Power Off".
2. After it is powered off, you can restore a backup by clicking on the "Backups" tab.
   * Once in the "Backups" tab, select the "Actions" button and then select the "Restore to Existing Linode" option.
   * This will open a menu to the right. In that menu, select the "Ubuntu-22.04-Longhair-Prod" Linode and then click the "Overwrite Linode" checkbox. Then click the "Restore" button to restore the backup to the Linode server.
3. Once the restore is complete, power the server back on by clicking on clicking on the "Actions" button and then selecting "Power On".