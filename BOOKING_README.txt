Booking storage and troubleshooting

- Bookings are recorded to `bookings.csv` in the `hscp_website` folder. Each row contains: event_type,event_date,venue,email,notes,poster_filename,timestamp

- A log is written to `bookings.log` with a short entry for each submission indicating whether PHP's mail() returned OK or FAIL.

- Uploaded poster files are saved to the `uploads/` folder with names like `poster_163...jpg`.

Troubleshooting mail()
- PHP's mail() needs a working mail transfer agent (MTA) or SMTP relay configured on the server. On Windows or some local setups mail() will appear to succeed but not deliver.
- For reliable email delivery, use PHPMailer or an API provider (SendGrid, Mailgun). I can add PHPMailer and SMTP configuration if you want.

Permissions
- Ensure the web server user has write permission to the repository folder for `bookings.csv`, `bookings.log`, and `uploads/`.

If you want, I can:
- Add PHPMailer and a configuration form to set SMTP credentials.
- Attach the uploaded poster to the outgoing email.
- Add an admin page to list bookings from `bookings.csv` with download links for posters.
