namespace InvestHypeWorker
{
    partial class Form1
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.components = new System.ComponentModel.Container();
            this.richTextBox1 = new System.Windows.Forms.RichTextBox();
            this.startButton = new System.Windows.Forms.Button();
            this.newsTimer = new System.Windows.Forms.Timer(this.components);
            this.newsWorker = new System.ComponentModel.BackgroundWorker();
            this.facebookWorker = new System.ComponentModel.BackgroundWorker();
            this.twitterWorker = new System.ComponentModel.BackgroundWorker();
            this.linkedInWorker = new System.ComponentModel.BackgroundWorker();
            this.diCommentsWorker = new System.ComponentModel.BackgroundWorker();
            this.webBrowser1 = new System.Windows.Forms.WebBrowser();
            this.popularWorker = new System.ComponentModel.BackgroundWorker();
            this.imageUpdateWorker = new System.ComponentModel.BackgroundWorker();
            this.imageResizeWorker = new System.ComponentModel.BackgroundWorker();
            this.button1 = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // 
            // richTextBox1
            // 
            this.richTextBox1.Location = new System.Drawing.Point(780, 13);
            this.richTextBox1.Name = "richTextBox1";
            this.richTextBox1.Size = new System.Drawing.Size(418, 214);
            this.richTextBox1.TabIndex = 0;
            this.richTextBox1.Text = "";
            // 
            // startButton
            // 
            this.startButton.Location = new System.Drawing.Point(780, 240);
            this.startButton.Name = "startButton";
            this.startButton.Size = new System.Drawing.Size(75, 23);
            this.startButton.TabIndex = 1;
            this.startButton.Text = "Start";
            this.startButton.UseVisualStyleBackColor = true;
            this.startButton.Click += new System.EventHandler(this.startButton_Click);
            // 
            // newsTimer
            // 
            this.newsTimer.Interval = 300000;
            this.newsTimer.Tick += new System.EventHandler(this.newsTimer_Tick);
            // 
            // newsWorker
            // 
            this.newsWorker.WorkerReportsProgress = true;
            this.newsWorker.DoWork += new System.ComponentModel.DoWorkEventHandler(this.newsWorker_DoWork);
            this.newsWorker.ProgressChanged += new System.ComponentModel.ProgressChangedEventHandler(this.newsWorker_ProgressChanged);
            this.newsWorker.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this.newsWorker_RunWorkerCompleted);
            // 
            // facebookWorker
            // 
            this.facebookWorker.WorkerReportsProgress = true;
            this.facebookWorker.DoWork += new System.ComponentModel.DoWorkEventHandler(this.facebookWorker_DoWork);
            this.facebookWorker.ProgressChanged += new System.ComponentModel.ProgressChangedEventHandler(this.facebookWorker_ProgressChanged);
            this.facebookWorker.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this.facebookWorker_RunWorkerCompleted);
            // 
            // twitterWorker
            // 
            this.twitterWorker.WorkerReportsProgress = true;
            this.twitterWorker.DoWork += new System.ComponentModel.DoWorkEventHandler(this.twitterWorker_DoWork);
            this.twitterWorker.ProgressChanged += new System.ComponentModel.ProgressChangedEventHandler(this.twitterWorker_ProgressChanged);
            this.twitterWorker.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this.twitterWorker_RunWorkerCompleted);
            // 
            // linkedInWorker
            // 
            this.linkedInWorker.WorkerReportsProgress = true;
            this.linkedInWorker.DoWork += new System.ComponentModel.DoWorkEventHandler(this.linkedInWorker_DoWork);
            this.linkedInWorker.ProgressChanged += new System.ComponentModel.ProgressChangedEventHandler(this.linkedInWorker_ProgressChanged);
            this.linkedInWorker.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this.linkedInWorker_RunWorkerCompleted);
            // 
            // diCommentsWorker
            // 
            this.diCommentsWorker.WorkerReportsProgress = true;
            this.diCommentsWorker.DoWork += new System.ComponentModel.DoWorkEventHandler(this.diCommentsWorker_DoWork);
            this.diCommentsWorker.ProgressChanged += new System.ComponentModel.ProgressChangedEventHandler(this.diCommentsWorker_ProgressChanged);
            this.diCommentsWorker.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this.diCommentsWorker_RunWorkerCompleted);
            // 
            // webBrowser1
            // 
            this.webBrowser1.Location = new System.Drawing.Point(12, 13);
            this.webBrowser1.MinimumSize = new System.Drawing.Size(20, 20);
            this.webBrowser1.Name = "webBrowser1";
            this.webBrowser1.Size = new System.Drawing.Size(727, 610);
            this.webBrowser1.TabIndex = 2;
            this.webBrowser1.DocumentCompleted += new System.Windows.Forms.WebBrowserDocumentCompletedEventHandler(this.webBrowser1_DocumentCompleted);
            // 
            // popularWorker
            // 
            this.popularWorker.WorkerReportsProgress = true;
            this.popularWorker.DoWork += new System.ComponentModel.DoWorkEventHandler(this.popularWorker_DoWork);
            this.popularWorker.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this.popularWorker_RunWorkerCompleted);
            // 
            // imageUpdateWorker
            // 
            this.imageUpdateWorker.WorkerReportsProgress = true;
            this.imageUpdateWorker.DoWork += new System.ComponentModel.DoWorkEventHandler(this.imageUpdateWorker_DoWork);
            this.imageUpdateWorker.ProgressChanged += new System.ComponentModel.ProgressChangedEventHandler(this.imageUpdateWorker_ProgressChanged);
            // 
            // imageResizeWorker
            // 
            this.imageResizeWorker.WorkerReportsProgress = true;
            this.imageResizeWorker.DoWork += new System.ComponentModel.DoWorkEventHandler(this.imageResizeWorker_DoWork);
            this.imageResizeWorker.ProgressChanged += new System.ComponentModel.ProgressChangedEventHandler(this.imageResizeWorker_ProgressChanged);
            // 
            // button1
            // 
            this.button1.Location = new System.Drawing.Point(780, 318);
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size(75, 23);
            this.button1.TabIndex = 3;
            this.button1.Text = "button1";
            this.button1.UseVisualStyleBackColor = true;
            this.button1.Click += new System.EventHandler(this.button1_Click);
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(1210, 635);
            this.Controls.Add(this.button1);
            this.Controls.Add(this.startButton);
            this.Controls.Add(this.richTextBox1);
            this.Controls.Add(this.webBrowser1);
            this.Name = "Form1";
            this.Text = "Form1";
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.RichTextBox richTextBox1;
        private System.Windows.Forms.Button startButton;
        private System.Windows.Forms.Timer newsTimer;
        private System.ComponentModel.BackgroundWorker newsWorker;
        private System.ComponentModel.BackgroundWorker facebookWorker;
        private System.ComponentModel.BackgroundWorker twitterWorker;
        private System.ComponentModel.BackgroundWorker linkedInWorker;
        private System.ComponentModel.BackgroundWorker diCommentsWorker;
        private System.Windows.Forms.WebBrowser webBrowser1;
        private System.ComponentModel.BackgroundWorker popularWorker;
        private System.ComponentModel.BackgroundWorker imageUpdateWorker;
        private System.ComponentModel.BackgroundWorker imageResizeWorker;
        private System.Windows.Forms.Button button1;

    }
}

