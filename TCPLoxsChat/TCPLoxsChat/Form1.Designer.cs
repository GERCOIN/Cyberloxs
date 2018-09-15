namespace TCPLoxsChat
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
			this.btnStart = new System.Windows.Forms.Button();
			this.label1 = new System.Windows.Forms.Label();
			this.txtHost = new System.Windows.Forms.TextBox();
			this.btnStop = new System.Windows.Forms.Button();
			this.txtPort = new System.Windows.Forms.TextBox();
			this.label2 = new System.Windows.Forms.Label();
			this.txtStatus = new System.Windows.Forms.TextBox();
			this.SuspendLayout();
			// 
			// btnStart
			// 
			this.btnStart.Location = new System.Drawing.Point(160, 11);
			this.btnStart.Name = "btnStart";
			this.btnStart.Size = new System.Drawing.Size(75, 23);
			this.btnStart.TabIndex = 0;
			this.btnStart.Text = "Запустить";
			this.btnStart.UseVisualStyleBackColor = true;
			this.btnStart.Click += new System.EventHandler(this.BtnStart_Click);
			// 
			// label1
			// 
			this.label1.AutoSize = true;
			this.label1.Location = new System.Drawing.Point(14, 16);
			this.label1.Name = "label1";
			this.label1.Size = new System.Drawing.Size(34, 13);
			this.label1.TabIndex = 1;
			this.label1.Text = "Хост:";
			// 
			// txtHost
			// 
			this.txtHost.Location = new System.Drawing.Point(54, 13);
			this.txtHost.Name = "txtHost";
			this.txtHost.Size = new System.Drawing.Size(100, 20);
			this.txtHost.TabIndex = 2;
			this.txtHost.Text = "127.0.0.1";
			// 
			// btnStop
			// 
			this.btnStop.Location = new System.Drawing.Point(160, 40);
			this.btnStop.Name = "btnStop";
			this.btnStop.Size = new System.Drawing.Size(75, 23);
			this.btnStop.TabIndex = 3;
			this.btnStop.Text = "Остановить";
			this.btnStop.UseVisualStyleBackColor = true;
			this.btnStop.Click += new System.EventHandler(this.BtnStop_Click);
			// 
			// txtPort
			// 
			this.txtPort.Location = new System.Drawing.Point(54, 42);
			this.txtPort.Name = "txtPort";
			this.txtPort.Size = new System.Drawing.Size(46, 20);
			this.txtPort.TabIndex = 5;
			this.txtPort.Text = "8910";
			// 
			// label2
			// 
			this.label2.AutoSize = true;
			this.label2.Location = new System.Drawing.Point(14, 45);
			this.label2.Name = "label2";
			this.label2.Size = new System.Drawing.Size(35, 13);
			this.label2.TabIndex = 4;
			this.label2.Text = "Порт:";
			// 
			// txtStatus
			// 
			this.txtStatus.Location = new System.Drawing.Point(17, 71);
			this.txtStatus.Multiline = true;
			this.txtStatus.Name = "txtStatus";
			this.txtStatus.Size = new System.Drawing.Size(420, 216);
			this.txtStatus.TabIndex = 6;
			// 
			// Form1
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(449, 296);
			this.Controls.Add(this.txtStatus);
			this.Controls.Add(this.txtPort);
			this.Controls.Add(this.label2);
			this.Controls.Add(this.btnStop);
			this.Controls.Add(this.txtHost);
			this.Controls.Add(this.label1);
			this.Controls.Add(this.btnStart);
			this.Name = "Form1";
			this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
			this.Text = "Server";
			this.Load += new System.EventHandler(this.Form1_Load);
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.Button btnStart;
		private System.Windows.Forms.Label label1;
		private System.Windows.Forms.TextBox txtHost;
		private System.Windows.Forms.Button btnStop;
		private System.Windows.Forms.TextBox txtPort;
		private System.Windows.Forms.Label label2;
		private System.Windows.Forms.TextBox txtStatus;
	}
}

