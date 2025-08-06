import smtplib
try:
    server = smtplib.SMTP('smtp-relay.brevo.com', 587, timeout=10)
    server.starttls()
    server.login('935d55302@smtp-brevo.com', '3NUCyV0cbGk3RITf')
    print("SMTP login successful")
    server.quit()
except Exception as e:
    print("Error: ", e)
