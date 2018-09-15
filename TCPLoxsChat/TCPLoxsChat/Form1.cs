using SimpleTCP;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace TCPLoxsChat
{
	public partial class Form1 : Form
	{
		public Form1()
		{
			InitializeComponent();
		}

		SimpleTcpServer server;

		private void Form1_Load(object sender, EventArgs e)
		{
			server = new SimpleTcpServer
			{
				Delimiter = 0x13,
				StringEncoder = Encoding.UTF8
			};
			server.DataReceived += Server_DataRecieved;
		}

		private void Server_DataRecieved(object sender, SimpleTCP.Message e)
		{
			txtStatus.Invoke((MethodInvoker)delegate ()
			{
				txtStatus.Text += e.MessageString;
				e.ReplyLine(string.Format("You said: {0}", e.MessageString));
			});
		}

		private void BtnStart_Click(object sender, EventArgs e)
		{
			txtStatus.Text += "Server is starting...0x0A";
			System.Net.IPAddress ip = System.Net.IPAddress.Parse(txtHost.Text);
			server.Start(ip, Convert.ToInt32(txtPort.Text));
			if (server.IsStarted)
				txtStatus.Text += "Server started.";
			else txtStatus.Text += "Start failed.";
		}

		private void BtnStop_Click(object sender, EventArgs e)
		{
			if (server.IsStarted)
			{
				server.Stop();
				txtStatus.Text += "Server stopped.";
			}
		}
	}
}
