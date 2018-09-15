namespace Client
{
	partial class Form1
	{
		/// <summary>
		/// Обязательная переменная конструктора.
		/// </summary>
		private System.ComponentModel.IContainer components = null;

		/// <summary>
		/// Освободить все используемые ресурсы.
		/// </summary>
		/// <param name="disposing">истинно, если управляемый ресурс должен быть удален; иначе ложно.</param>
		protected override void Dispose(bool disposing)
		{
			if (disposing && (components != null))
			{
				components.Dispose();
			}
			base.Dispose(disposing);
		}

		#region Код, автоматически созданный конструктором форм Windows

		/// <summary>
		/// Требуемый метод для поддержки конструктора — не изменяйте 
		/// содержимое этого метода с помощью редактора кода.
		/// </summary>
		private void InitializeComponent()
		{
			this.txtHost = new System.Windows.Forms.TextBox();
			this.label1 = new System.Windows.Forms.Label();
			this.btnConnect = new System.Windows.Forms.Button();
			this.txtPort = new System.Windows.Forms.TextBox();
			this.label2 = new System.Windows.Forms.Label();
			this.txtMessage = new System.Windows.Forms.TextBox();
			this.btnSend = new System.Windows.Forms.Button();
			this.txtStatus = new System.Windows.Forms.TextBox();
			this.label3 = new System.Windows.Forms.Label();
			this.SuspendLayout();
			// 
			// txtHost
			// 
			this.txtHost.Location = new System.Drawing.Point(50, 12);
			this.txtHost.Name = "txtHost";
			this.txtHost.Size = new System.Drawing.Size(100, 20);
			this.txtHost.TabIndex = 5;
			this.txtHost.Text = "127.0.0.1";
			// 
			// label1
			// 
			this.label1.AutoSize = true;
			this.label1.Location = new System.Drawing.Point(10, 15);
			this.label1.Name = "label1";
			this.label1.Size = new System.Drawing.Size(34, 13);
			this.label1.TabIndex = 4;
			this.label1.Text = "Хост:";
			// 
			// btnConnect
			// 
			this.btnConnect.Location = new System.Drawing.Point(249, 10);
			this.btnConnect.Name = "btnConnect";
			this.btnConnect.Size = new System.Drawing.Size(100, 23);
			this.btnConnect.TabIndex = 3;
			this.btnConnect.Text = "Присоединиться";
			this.btnConnect.UseVisualStyleBackColor = true;
			this.btnConnect.Click += new System.EventHandler(this.BtnConnect_Click);
			// 
			// txtPort
			// 
			this.txtPort.Location = new System.Drawing.Point(197, 12);
			this.txtPort.Name = "txtPort";
			this.txtPort.Size = new System.Drawing.Size(46, 20);
			this.txtPort.TabIndex = 7;
			this.txtPort.Text = "8910";
			// 
			// label2
			// 
			this.label2.AutoSize = true;
			this.label2.Location = new System.Drawing.Point(157, 15);
			this.label2.Name = "label2";
			this.label2.Size = new System.Drawing.Size(35, 13);
			this.label2.TabIndex = 6;
			this.label2.Text = "Порт:";
			// 
			// txtMessage
			// 
			this.txtMessage.Location = new System.Drawing.Point(12, 38);
			this.txtMessage.Multiline = true;
			this.txtMessage.Name = "txtMessage";
			this.txtMessage.Size = new System.Drawing.Size(425, 56);
			this.txtMessage.TabIndex = 8;
			// 
			// btnSend
			// 
			this.btnSend.Location = new System.Drawing.Point(362, 100);
			this.btnSend.Name = "btnSend";
			this.btnSend.Size = new System.Drawing.Size(75, 23);
			this.btnSend.TabIndex = 9;
			this.btnSend.Text = "Отправить";
			this.btnSend.UseVisualStyleBackColor = true;
			this.btnSend.Click += new System.EventHandler(this.BtnSend_Click);
			// 
			// txtStatus
			// 
			this.txtStatus.Location = new System.Drawing.Point(13, 129);
			this.txtStatus.Multiline = true;
			this.txtStatus.Name = "txtStatus";
			this.txtStatus.Size = new System.Drawing.Size(425, 155);
			this.txtStatus.TabIndex = 10;
			// 
			// label3
			// 
			this.label3.AutoSize = true;
			this.label3.Location = new System.Drawing.Point(12, 110);
			this.label3.Name = "label3";
			this.label3.Size = new System.Drawing.Size(86, 13);
			this.label3.TabIndex = 11;
			this.label3.Text = "Лог сообщений";
			// 
			// Form1
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(449, 296);
			this.Controls.Add(this.label3);
			this.Controls.Add(this.txtStatus);
			this.Controls.Add(this.btnSend);
			this.Controls.Add(this.txtMessage);
			this.Controls.Add(this.txtPort);
			this.Controls.Add(this.label2);
			this.Controls.Add(this.txtHost);
			this.Controls.Add(this.label1);
			this.Controls.Add(this.btnConnect);
			this.Name = "Form1";
			this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
			this.Text = "Client";
			this.Load += new System.EventHandler(this.Form1_Load);
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.TextBox txtHost;
		private System.Windows.Forms.Label label1;
		private System.Windows.Forms.Button btnConnect;
		private System.Windows.Forms.TextBox txtPort;
		private System.Windows.Forms.Label label2;
		private System.Windows.Forms.TextBox txtMessage;
		private System.Windows.Forms.Button btnSend;
		private System.Windows.Forms.TextBox txtStatus;
		private System.Windows.Forms.Label label3;
	}
}

