using Common.DataAccess;
using Microsoft.Win32;
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Drawing.Drawing2D;
using System.Drawing.Imaging;
using System.IO;
using System.Linq;
using System.Net;
using System.ServiceModel.Syndication;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading;
using System.Threading.Tasks;
using System.Web;
using System.Windows.Forms;
using System.Xml;
using System.Xml.Linq;

namespace InvestHypeWorker
{
    public partial class Form1 : Form
    {
        bool pageVisited = false;
        int webcounter = 0;
        public Form1()
        {
            SetWebBrowserFeatures();
            InitializeComponent();
            webBrowser1.ScriptErrorsSuppressed = true;
        }

        private void startButton_Click(object sender, EventArgs e)
        {

            newsTimer.Start();
            if (!newsWorker.IsBusy)
            {
                newsWorker.RunWorkerAsync();
            }
            if (!facebookWorker.IsBusy)
            {
                facebookWorker.RunWorkerAsync();
            }
            if (!twitterWorker.IsBusy)
            {
                twitterWorker.RunWorkerAsync();
            }
            if (!linkedInWorker.IsBusy)
            {
                linkedInWorker.RunWorkerAsync();
            }
            if (!diCommentsWorker.IsBusy)
            {
                diCommentsWorker.RunWorkerAsync();
            }
            if (!popularWorker.IsBusy)
            {
                popularWorker.RunWorkerAsync();
            }
            if (!imageUpdateWorker.IsBusy)
            {
                imageUpdateWorker.RunWorkerAsync();
            }
        }

        private void newsWorker_DoWork(object sender, DoWorkEventArgs e)
        {
            string[] feeds = new string[]{ "http://di.se/rss",
                                        "http://www.svd.se/naringsliv/?service=rss",
                                        "http://www.dn.se/ekonomi/m/rss", 
                                        "http://www.affarsvarlden.se/?service=rss",
                                        "http://www.svt.se/nyheter/ekonomi/rss.xml",
                                        "http://www.privataaffarer.se/rss",
                                        "http://www.va.se/rss/",
                                        "http://www.realtid.se/rss/senaste",
                                        "http://www.efn.se/feed",
                                        "http://www.aktiespararna.se/templates/RSS.aspx?pageid=60427&list=1"};
            for (int i = 0; i < feeds.Length; i++)
            {

                XmlReader reader = null;
                SyndicationFeed feed = null;
                try
                {
                    reader = MyXmlReader.Create(feeds[i]);
                    feed = SyndicationFeed.Load(reader);
                    reader.Close();
                }
                catch (Exception ex)
                {

                }

                if (feed != null)
                {
                    foreach (SyndicationItem item in feed.Items)
                    {
                        string subject = item.Title.Text;
                        subject = HttpUtility.HtmlDecode(subject.Trim());
                        string summary = item.Summary.Text;

                        summary = summary.Trim();
                        string img = "";
                        if (summary.Contains("<img"))
                        {
                            if (summary.Contains(">") && summary.Contains("src"))
                            {
                                img = summary.Substring(summary.IndexOf("src=") + 5);
                                img = img.Substring(0, img.IndexOf("\""));
                                string begin = summary.Substring(0, summary.IndexOf("<img"));
                                string end = summary.Substring(summary.IndexOf(">") + 1);
                                summary = begin + end;
                                summary = summary.Replace("<br>", "");
                                summary = summary.Replace("<\br>", "");
                                summary = summary.Replace("<br />", "");
                            }
                        }
                        DateTime updateTime = item.PublishDate.LocalDateTime;

                        string link = item.Links[0].Uri.ToString();

                        IDBOperator idb = DBOperator.GetInstance();
                        string sql = "select id from article where ( title = @title or link = @link ) and date >= DATE_SUB(@date,INTERVAL 1 HOUR)";
                        idb.AddParameter("@title", subject);
                        idb.AddParameter("@date", updateTime);
                        idb.AddParameter("@link", link);
                        DataTable dt = idb.ReturnDataTable(sql);
                        if (dt.Rows.Count == 0 && !link.Equals("http://www.privataaffarer.se/chatt") && !link.Equals("http://www.privataaffarer.se/"))
                        {
                            string image = "";
                            if (img.Length > 0)
                            {
                                image = img;
                            }
                            else
                            {
                                using (WebClient wbc = new WebClient())
                                {
                                    try
                                    {
                                        string html = wbc.DownloadString(link);
                                        if (html.Contains("og:image"))
                                        {
                                            html = html.Substring(html.IndexOf("og:image"));
                                            html = html.Substring(html.IndexOf("=") + 1);
                                            html = html.Substring(0, html.IndexOf("/>"));
                                            if (html.Contains(">"))
                                            {
                                                html = html.Substring(0, html.IndexOf(">"));
                                            }
                                            html = html.Replace("\"", "");
                                            html = html.Replace("'", "");
                                            html = html.Replace(" ", "");
                                            image = HttpUtility.HtmlDecode(html);
                                        }
                                    }
                                    catch (Exception ex)
                                    {
                                    }
                                }
                            }

                            string insert = "INSERT INTO article (title, link, image, summary, sourceId, date) VALUES (@title, @link, @image, @summary, @sourceId, @date)";
                            idb.AddParameter("@title", subject);
                            idb.AddParameter("@link", link);
                            idb.AddParameter("@image", image);
                            idb.AddParameter("@summary", summary);
                            idb.AddParameter("@sourceId", (i + 1));
                            idb.AddParameter("@date", updateTime);
                            idb.ExeCmd(insert);
                            newsWorker.ReportProgress(0, subject);
                            string imageUrl = image;
                            string sql2 = "select id, title, date from article where url is null ";
                            DataTable dt2 = idb.ReturnDataTable(sql2);
                            for (int ij = 0; ij < dt2.Rows.Count; ij++)
                            {
                                string id = dt2.Rows[ij]["id"].ToString();
                                string title = dt2.Rows[ij]["title"].ToString();
                                title = title.ToLower().Replace("å", "a").Replace("ä", "a").Replace("ö", "o");
                                DateTime date = (DateTime)dt2.Rows[ij]["date"];
                                Regex rgx = new Regex("[^a-zA-Z0-9 -]");
                                title = rgx.Replace(title, "");
                                string url = "/" + date.Year + "/" + date.Month + "/" + date.Day + "/" + title.Replace(" ", "-") + "-" + id + "/";
                                string update = "UPDATE article SET url=@url WHERE id=@id;";
                                idb.AddParameter("@id", id);
                                idb.AddParameter("@url", url);
                                idb.ExeCmd(update);
                                newsWorker.ReportProgress(1, "http://investhype.com/nyheter" + url);
                                if (imageUrl.Length > 0 && !imageUrl.Contains("Not Found"))
                                {

                                    WebClient wc = new WebClient();
                                    string imgg = HttpUtility.HtmlDecode(imageUrl);
                                    try
                                    {
                                        wc.DownloadFile(imgg, "C:\\chrispersson.com\\artikelbilder\\" + id + "org.jpg");
                                        Bitmap bp = (Bitmap)Bitmap.FromFile("C:\\chrispersson.com\\artikelbilder\\" + id + "org.jpg");
                                        float width = 867;
                                        if (bp.Width < width)
                                        {
                                            width = bp.Width;
                                        }
                                        float scale = (float)width / bp.Width;
                                        float height = bp.Height * scale;
                                        var bmp = new Bitmap((int)width, (int)height);
                                        var graph = Graphics.FromImage(bmp);

                                        // uncomment for higher quality output
                                        graph.InterpolationMode = InterpolationMode.High;
                                        graph.CompositingQuality = CompositingQuality.HighQuality;
                                        graph.SmoothingMode = SmoothingMode.AntiAlias;
                                        graph.DrawImage(bp, new Rectangle(0, 0, (int)width, (int)height));

                                        System.Drawing.Imaging.Encoder myEncoder = System.Drawing.Imaging.Encoder.Quality;

                                        EncoderParameters myEncoderParameters = new EncoderParameters(1);

                                        EncoderParameter myEncoderParameter = new EncoderParameter(myEncoder,
                                            90L);
                                        myEncoderParameters.Param[0] = myEncoderParameter;
                                        ImageCodecInfo jgpEncoder = GetEncoder(ImageFormat.Jpeg);
                                        title = title.Replace(" ", "-");
                                        bmp.Save("C:\\chrispersson.com\\artikelbilder\\" + id + "-" + title + ".jpg", jgpEncoder,
                                             myEncoderParameters);
                                        bmp.Dispose();
                                        bp.Dispose();

                                        update = "UPDATE article SET localimage=@url WHERE id=@id;";
                                        idb.AddParameter("@id", id);
                                        idb.AddParameter("@url", "http://investhype.com/artikelbilder/" + id + "-" + title + ".jpg");
                                        idb.ExeCmd(update);

                                    }
                                    catch (Exception exc) { }

                                    Thread.Sleep(5 * 1000);
                                }


                                string sql4 = "select id, strict, word, hashtagId from keyword";
                                DataTable dt4 = idb.ReturnDataTable(sql4);
                                string sql3 = "select id, title, summary from article where hashtags is null ";
                                DataTable dt3 = idb.ReturnDataTable(sql3);
                                for (int ik = 0; ik < dt3.Rows.Count; ik++)
                                {
                                    string aid = dt3.Rows[ik]["id"].ToString();
                                    string atext = dt3.Rows[ik]["title"].ToString() + " " + dt3.Rows[ik]["summary"].ToString();
                                    for (int jj = 0; jj < dt4.Rows.Count; jj++)
                                    {
                                        string kid = dt4.Rows[jj]["id"].ToString();
                                        int kstrict = (int)dt4.Rows[jj]["strict"];
                                        string kword = dt4.Rows[jj]["word"].ToString();
                                        string khashtagId = dt4.Rows[jj]["hashtagId"].ToString();
                                        string aatext = atext;
                                        if (kstrict == 0)
                                        {
                                            aatext = atext.ToLower();
                                        }
                                        if (aatext.Contains(kword))
                                        {
                                            string insertHT = "INSERT INTO articlehashtags (articleId, hashtagId) VALUES (@articleId, @hashtagId)";
                                            idb.AddParameter("@articleId", aid);
                                            idb.AddParameter("@hashtagId", khashtagId);
                                            idb.ExeCmd(insertHT);
                                        }
                                    }

                                    string hhh = "#finans #ekonomi #sveko";
                                    string sql5 = "select articlehashtags.articleId, articlehashtags.hashtagId, hashtags.tag from articlehashtags, article, hashtags where article.id = articlehashtags.articleId and hashtags.id = articlehashtags.hashtagId and article.id = @id group by articlehashtags.hashtagId";
                                    idb.AddParameter("@id", aid);
                                    DataTable dt5 = idb.ReturnDataTable(sql5);
                                    for (int jk = 0; jk < dt5.Rows.Count; jk++)
                                    {
                                        string ktag = dt5.Rows[jk]["tag"].ToString();
                                        hhh = ktag + " " + hhh;
                                    }

                                    string update2 = "UPDATE article SET hashtags=@hashtags WHERE id=@id;";
                                    idb.AddParameter("@id", aid);
                                    idb.AddParameter("@hashtags", hhh);
                                    idb.ExeCmd(update2);
                                }
                            }
                           
                            
                        }

                    }
                }
            }
        }

        private void newsTimer_Tick(object sender, EventArgs e)
        {
            if (!newsWorker.IsBusy)
            {
                newsWorker.RunWorkerAsync();
            }
            if (!facebookWorker.IsBusy)
            {
                facebookWorker.RunWorkerAsync();
            }
            if (!twitterWorker.IsBusy)
            {
                twitterWorker.RunWorkerAsync();
            }
            if (!linkedInWorker.IsBusy)
            {
                linkedInWorker.RunWorkerAsync();
            }
            if (!diCommentsWorker.IsBusy)
            {
                diCommentsWorker.RunWorkerAsync();
            }
            if (!popularWorker.IsBusy)
            {
                popularWorker.RunWorkerAsync();
            }
            if (!imageUpdateWorker.IsBusy)
            {
                imageUpdateWorker.RunWorkerAsync();
            }
        }

        private void newsWorker_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            if (e.ProgressPercentage == 0)
            {
                richTextBox1.AppendText("Article added " + (string)e.UserState + "\n");
                richTextBox1.SelectionStart = richTextBox1.Text.Length;
                richTextBox1.ScrollToCaret();
            }
            else if (e.ProgressPercentage == 1)
            {
                webBrowser1.Navigate((string)e.UserState);
            }
        }

        private void newsWorker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            richTextBox1.Clear();
            richTextBox1.AppendText("Last complete news check at " + DateTime.Now.ToString() + "\n");
        }

        private void facebookWorker_DoWork(object sender, DoWorkEventArgs e)
        {
            IDBOperator idb = DBOperator.GetInstance();
            string sql = "select id, link, facebook, twitter, linkedIn, date from article where date >= DATE_SUB(NOW(),INTERVAL 72 HOUR)";
            DataTable dt = idb.ReturnDataTable(sql);
            for (int i = 0; i < dt.Rows.Count; i++)
            {
                string id = dt.Rows[i]["id"].ToString();
                string link = dt.Rows[i]["link"].ToString();
                int twitter = (int)dt.Rows[i]["twitter"];
                int linkedIn = (int)dt.Rows[i]["linkedIn"];
                DateTime ddt = (DateTime)dt.Rows[i]["date"];
                TimeSpan tss = DateTime.Now.Subtract(ddt);
                double multiplyer = 12 / (tss.TotalHours + 1);
                using (WebClient wbc = new WebClient())
                {
                    try
                    {
                        string resp = wbc.DownloadString("https://api.facebook.com/method/links.getStats?urls=" + link + "&format=json");
                        if (resp.Contains("total_count"))
                        {
                            resp = resp.Substring(resp.IndexOf("total_count"));
                            resp = resp.Substring(resp.IndexOf(":") + 1);
                            resp = resp.Substring(0, resp.IndexOf(","));
                            int cfb = int.Parse(resp);
                            if (cfb > 0)
                            {
                                int hypedscore = (int)((cfb + (2 * twitter) + (3 * linkedIn)) * multiplyer);
                                string update = "UPDATE article SET facebook=@facebook, hyped=@hyped WHERE id=@id;";
                                idb.AddParameter("@id", id);
                                idb.AddParameter("@facebook", cfb);
                                idb.AddParameter("@hyped", hypedscore);
                                idb.ExeCmd(update);
                                facebookWorker.ReportProgress(0, id);
                            }
                        }
                    }
                    catch (Exception exc) { }
                }
            }
        }

        private void facebookWorker_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            richTextBox1.AppendText("Article " + (string)e.UserState + " facebook count added \n");
            richTextBox1.SelectionStart = richTextBox1.Text.Length;
            richTextBox1.ScrollToCaret();
        }

        private void facebookWorker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            richTextBox1.AppendText("Last complete facebook check at " + DateTime.Now.ToString() + "\n");
        }

        private void twitterWorker_DoWork(object sender, DoWorkEventArgs e)
        {
            IDBOperator idb = DBOperator.GetInstance();
            string sql = "select id, link, facebook, twitter, linkedIn, date from article where date >= DATE_SUB(NOW(),INTERVAL 72 HOUR)";
            DataTable dt = idb.ReturnDataTable(sql);
            for (int i = 0; i < dt.Rows.Count; i++)
            {
                string id = dt.Rows[i]["id"].ToString();
                string link = dt.Rows[i]["link"].ToString();
                int facebook = (int)dt.Rows[i]["facebook"];
                int twitter = (int)dt.Rows[i]["twitter"];
                int linkedIn = (int)dt.Rows[i]["linkedIn"];
                DateTime ddt = (DateTime)dt.Rows[i]["date"];
                TimeSpan tss = DateTime.Now.Subtract(ddt);
                double multiplyer = 12 / (tss.TotalHours + 1);
                using (WebClient wbc = new WebClient())
                {
                    try
                    {
                        string resp = wbc.DownloadString("http://urls.api.twitter.com/1/urls/count.json?url=" + link);
                        if (resp.Contains("count"))
                        {
                            resp = resp.Substring(resp.IndexOf("count"));
                            resp = resp.Substring(resp.IndexOf(":") + 1);
                            resp = resp.Substring(0, resp.IndexOf(","));
                            int ctw = int.Parse(resp);
                            if (ctw > 0)
                            {
                                int hypedscore = (int)((facebook + (2 * ctw) + (3 * linkedIn)) * multiplyer);
                                string update = "UPDATE article SET twitter=@twitter, hyped=@hyped WHERE id=@id;";
                                idb.AddParameter("@id", id);
                                idb.AddParameter("@twitter", ctw);
                                idb.AddParameter("@hyped", hypedscore);
                                idb.ExeCmd(update);
                                twitterWorker.ReportProgress(0, id);
                            }
                        }
                    }
                    catch (Exception exc) { }
                }
            }
        }

        private void twitterWorker_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            richTextBox1.AppendText("Article " + (string)e.UserState + " twitter count added \n");
            richTextBox1.SelectionStart = richTextBox1.Text.Length;
            richTextBox1.ScrollToCaret();
        }

        private void twitterWorker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            richTextBox1.AppendText("Last complete twitter check at " + DateTime.Now.ToString() + "\n");
        }

        private void linkedInWorker_DoWork(object sender, DoWorkEventArgs e)
        {
            IDBOperator idb = DBOperator.GetInstance();
            string sql = "select id, link, facebook, twitter, linkedIn, date from article where date >= DATE_SUB(NOW(),INTERVAL 72 HOUR)";
            DataTable dt = idb.ReturnDataTable(sql);
            for (int i = 0; i < dt.Rows.Count; i++)
            {
                string id = dt.Rows[i]["id"].ToString();
                string link = dt.Rows[i]["link"].ToString();
                int facebook = (int)dt.Rows[i]["facebook"];
                int twitter = (int)dt.Rows[i]["twitter"];
                int linkedIn = (int)dt.Rows[i]["linkedIn"];
                DateTime ddt = (DateTime)dt.Rows[i]["date"];
                TimeSpan tss = DateTime.Now.Subtract(ddt);
                double multiplyer = 12 / (tss.TotalHours + 1);
                using (WebClient wbc = new WebClient())
                {
                    try
                    {
                        string resp = wbc.DownloadString("http://www.linkedin.com/countserv/count/share?url=" + link + "&format=json");
                        if (resp.Contains("count"))
                        {
                            resp = resp.Substring(resp.IndexOf("count"));
                            resp = resp.Substring(resp.IndexOf(":") + 1);
                            resp = resp.Substring(0, resp.IndexOf(","));
                            int cli = int.Parse(resp);
                            if (cli > 0)
                            {
                                int hypedscore = (int)((facebook + (2 * twitter) + (3 * linkedIn)) * multiplyer);
                                string update = "UPDATE article SET linkedIn=@linkedIn, hyped=@hyped WHERE id=@id;";
                                idb.AddParameter("@id", id);
                                idb.AddParameter("@linkedIn", cli);
                                idb.AddParameter("@hyped", hypedscore);
                                idb.ExeCmd(update);
                                linkedInWorker.ReportProgress(0, id);
                            }
                        }
                    }
                    catch (Exception exc) { }
                }
            }
        }

        private void linkedInWorker_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            richTextBox1.AppendText("Article " + (string)e.UserState + " linkedIn count added \n");
            richTextBox1.SelectionStart = richTextBox1.Text.Length;
            richTextBox1.ScrollToCaret();
        }

        private void linkedInWorker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            richTextBox1.AppendText("Last complete linkedIn check at " + DateTime.Now.ToString() + "\n");
        }

        private void diCommentsWorker_DoWork(object sender, DoWorkEventArgs e)
        {
            IDBOperator idb = DBOperator.GetInstance();
            string sql = "select id, link, url from article where sourceId = 1 and date >= DATE_SUB(NOW(),INTERVAL 24 HOUR)";
            DataTable dt = idb.ReturnDataTable(sql);

            for (int i = 0; i < dt.Rows.Count; i++)
            {

                string id = dt.Rows[i]["id"].ToString();
                string link = dt.Rows[i]["link"].ToString();
                string refurl = "http://investhype.com/nyheter" + dt.Rows[i]["url"].ToString();

                WebClient wc = new WebClient();
                wc.Encoding = Encoding.UTF8;
                try
                {
                    string html = wc.DownloadString(link + "?allakommentarer=&flik=senaste");
                    string st = html.Substring(html.IndexOf("data-parent-reference=") + 23);
                    st = st.Substring(0, st.IndexOf("'"));
                    string guid = html.Substring(html.IndexOf("data-parent-guid=") + 18);
                    guid = guid.Substring(0, guid.IndexOf("'"));
                    string url = "http://www.di.se/Comments/WebServices/CommentsService.svc/GetComments?ParentGuid=" + guid + "&ParentId=" + st + "&Filter=popularast&PageNumber=1&PageSize=100";
                    string json = wc.DownloadString(url);
                    while (json.Contains("Body"))
                    {
                        string body = json.Substring(json.IndexOf("\"Body\":") + 8);
                        body = body.Substring(0, body.IndexOf('"'));
                        string DIID = json.Substring(json.IndexOf("\"Id\":") + 5);
                        DIID = DIID.Substring(0, DIID.IndexOf(','));
                        string title = json.Substring(json.IndexOf("\"Title\":") + 9);
                        title = title.Substring(0, title.IndexOf('"'));
                        string username = json.Substring(json.IndexOf("\"UserName\":") + 12);
                        username = username.Substring(0, username.IndexOf('"'));
                        json = json.Substring(json.IndexOf("\"UserName\":") + 12);

                        string sql2 = "select id from comment where articleId = @articleId and diid = @diid";
                        idb.AddParameter("@diid", DIID);
                        idb.AddParameter("@articleId", id);
                        DataTable dt2 = idb.ReturnDataTable(sql2);
                        if (dt2.Rows.Count < 1)
                        {

                            string insert = "INSERT INTO comment (articleId, diid, title, username, body) VALUES (@articleId, @diid, @title, @username, @body)";
                            idb.AddParameter("@title", title);
                            idb.AddParameter("@diid", DIID);
                            idb.AddParameter("@articleId", id);
                            idb.AddParameter("@username", username);
                            idb.AddParameter("@body", body.Replace("\\u000d", "").Replace("\\u000a", "").Replace("\\", " ").Replace("\"", "'"));
                            idb.ExeCmd(insert);
                            diCommentsWorker.ReportProgress(0, id);



                            string jsres = wc.DownloadString("http://disqus.com/api/3.0/threads/list.json?api_key=tSXzVs6wcyR3nKcCgcTCDWV9GxJicthV7nUsRZoDfcceYtwekaQXVvwYEtCMa8RT&forum=invest-hype&thread=link:" + refurl);
                            if (jsres.Contains("\"id\":"))
                            {
                                jsres = jsres.Substring(jsres.IndexOf("\"id\":") + 6);
                                jsres = jsres.Substring(jsres.IndexOf("\"id\":") + 6);
                                string threadId = jsres.Substring(0, jsres.IndexOf('"'));

                                byte[] response = wc.UploadValues("http://investhype.com/newcomment.php", new NameValueCollection()
                            {
                                { "id", threadId },
                                { "message", title + "\n" + body.Replace("\\u000d", "").Replace("\\u000a", "").Replace("\\", "") },
                                { "username", username }
                            });

                                string result = System.Text.Encoding.UTF8.GetString(response);
                            }

                        }
                    }
                }
                catch (WebException we) { }
            }
        }

        private void diCommentsWorker_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            if (e.ProgressPercentage == 0)
            {
                richTextBox1.AppendText("Comment added for Article " + (string)e.UserState + " \n");
                richTextBox1.SelectionStart = richTextBox1.Text.Length;
                richTextBox1.ScrollToCaret();
            }


        }

        private void diCommentsWorker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {
            richTextBox1.AppendText("Last complete comments check at " + DateTime.Now.ToString() + "\n");
        }

        private void webBrowser1_DocumentCompleted(object sender, WebBrowserDocumentCompletedEventArgs e)
        {

        }


        // set WebBrowser features, more info: http://stackoverflow.com/a/18333982/1768303
        static void SetWebBrowserFeatures()
        {
            // don't change the registry if running in-proc inside Visual Studio
            if (LicenseManager.UsageMode != LicenseUsageMode.Runtime)
                return;

            var appName = System.IO.Path.GetFileName(System.Diagnostics.Process.GetCurrentProcess().MainModule.FileName);

            var featureControlRegKey = @"HKEY_CURRENT_USER\Software\Microsoft\Internet Explorer\Main\FeatureControl\";

            Registry.SetValue(featureControlRegKey + "FEATURE_BROWSER_EMULATION",
                appName, GetBrowserEmulationMode(), RegistryValueKind.DWord);

            // enable the features which are "On" for the full Internet Explorer browser

            Registry.SetValue(featureControlRegKey + "FEATURE_ENABLE_CLIPCHILDREN_OPTIMIZATION",
                appName, 1, RegistryValueKind.DWord);

            Registry.SetValue(featureControlRegKey + "FEATURE_AJAX_CONNECTIONEVENTS",
                appName, 1, RegistryValueKind.DWord);

            Registry.SetValue(featureControlRegKey + "FEATURE_GPU_RENDERING",
                appName, 1, RegistryValueKind.DWord);

            Registry.SetValue(featureControlRegKey + "FEATURE_WEBOC_DOCUMENT_ZOOM",
                appName, 1, RegistryValueKind.DWord);

            Registry.SetValue(featureControlRegKey + "FEATURE_NINPUT_LEGACYMODE",
                appName, 0, RegistryValueKind.DWord);
        }

        static UInt32 GetBrowserEmulationMode()
        {
            int browserVersion = 0;
            using (var ieKey = Registry.LocalMachine.OpenSubKey(@"SOFTWARE\Microsoft\Internet Explorer",
                RegistryKeyPermissionCheck.ReadSubTree,
                System.Security.AccessControl.RegistryRights.QueryValues))
            {
                var version = ieKey.GetValue("svcVersion");
                if (null == version)
                {
                    version = ieKey.GetValue("Version");
                    if (null == version)
                        throw new ApplicationException("Microsoft Internet Explorer is required!");
                }
                int.TryParse(version.ToString().Split('.')[0], out browserVersion);
            }

            if (browserVersion < 7)
            {
                throw new ApplicationException("Unsupported version of Microsoft Internet Explorer!");
            }

            UInt32 mode = 11000; // Internet Explorer 11. Webpages containing standards-based !DOCTYPE directives are displayed in IE11 Standards mode. 

            switch (browserVersion)
            {
                case 7:
                    mode = 7000; // Webpages containing standards-based !DOCTYPE directives are displayed in IE7 Standards mode. 
                    break;
                case 8:
                    mode = 8000; // Webpages containing standards-based !DOCTYPE directives are displayed in IE8 mode. 
                    break;
                case 9:
                    mode = 9000; // Internet Explorer 9. Webpages containing standards-based !DOCTYPE directives are displayed in IE9 mode.                    
                    break;
                case 10:
                    mode = 10000; // Internet Explorer 10.
                    break;
            }

            return mode;
        }

        private void popularWorker_DoWork(object sender, DoWorkEventArgs e)
        {
            IDBOperator idb = DBOperator.GetInstance();
            string sql = "select id, link, url from article where hyped > 250 and date >= DATE_SUB(NOW(),INTERVAL 24 HOUR) and id not in (select articleId from popular)";
            DataTable dt = idb.ReturnDataTable(sql);

            for (int i = 0; i < dt.Rows.Count; i++)
            {

                string id = dt.Rows[i]["id"].ToString();
                string insert = "INSERT INTO popular (articleId) VALUES (@articleId)";
                idb.AddParameter("@articleId", id);
                idb.ExeCmd(insert);
            }
        }

        private void popularWorker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
        {

        }

        private void imageUpdateWorker_DoWork(object sender, DoWorkEventArgs e)
        {
            IDBOperator idb = DBOperator.GetInstance();
            string sql = "select id, link, url, title from article where hyped > 50 and date >= DATE_SUB(NOW(),INTERVAL 24 HOUR) and CHAR_LENGTH(image) < 1";
            DataTable dt = idb.ReturnDataTable(sql);

            for (int i = 0; i < dt.Rows.Count; i++)
            {

                string id = dt.Rows[i]["id"].ToString();
                string link = dt.Rows[i]["link"].ToString();
                using (WebClient wbc = new WebClient())
                {
                    try
                    {
                        string html = wbc.DownloadString(link);
                        if (html.Contains("og:image"))
                        {
                            html = html.Substring(html.IndexOf("og:image"));
                            html = html.Substring(html.IndexOf("=") + 1);
                            html = html.Substring(0, html.IndexOf("/>"));
                            if (html.Contains(">"))
                            {
                                html = html.Substring(0, html.IndexOf(">"));
                            }
                            html = html.Replace("\"", "");
                            html = html.Replace("'", "");
                            html = html.Replace(" ", "");
                            string imageUrl = html;
                            if (imageUrl.Length > 0)
                            {
                                string update = "UPDATE article SET image=@image WHERE id=@id;";
                                idb.AddParameter("@id", id);
                                idb.AddParameter("@image", imageUrl);
                                idb.ExeCmd(update);
                                imageUpdateWorker.ReportProgress(0, id);

                                if (imageUrl.Length > 0 && !imageUrl.Contains("Not Found"))
                                {

                                    WebClient wc = new WebClient();
                                    string imgg = HttpUtility.HtmlDecode(imageUrl);
                                    try
                                    {
                                        wc.DownloadFile(imgg, "C:\\chrispersson.com\\artikelbilder\\" + id + "org.jpg");
                                        Bitmap bp = (Bitmap)Bitmap.FromFile("C:\\chrispersson.com\\artikelbilder\\" + id + "org.jpg");
                                        float width = 867;
                                        if (bp.Width < width)
                                        {
                                            width = bp.Width;
                                        }
                                        float scale = (float)width / bp.Width;
                                        float height = bp.Height * scale;
                                        var bmp = new Bitmap((int)width, (int)height);
                                        var graph = Graphics.FromImage(bmp);

                                        // uncomment for higher quality output
                                        graph.InterpolationMode = InterpolationMode.High;
                                        graph.CompositingQuality = CompositingQuality.HighQuality;
                                        graph.SmoothingMode = SmoothingMode.AntiAlias;
                                        graph.DrawImage(bp, new Rectangle(0, 0, (int)width, (int)height));

                                        System.Drawing.Imaging.Encoder myEncoder = System.Drawing.Imaging.Encoder.Quality;

                                        EncoderParameters myEncoderParameters = new EncoderParameters(1);

                                        EncoderParameter myEncoderParameter = new EncoderParameter(myEncoder,
                                            90L);
                                        myEncoderParameters.Param[0] = myEncoderParameter;
                                        ImageCodecInfo jgpEncoder = GetEncoder(ImageFormat.Jpeg);
                                        string tt = RemoveInvalidFilePathCharacters(dt.Rows[i]["title"].ToString(), "");
                                        bmp.Save("C:\\chrispersson.com\\artikelbilder\\" + id + "-" + tt + ".jpg", jgpEncoder,
                                            myEncoderParameters);
                                        bmp.Dispose();
                                        bp.Dispose();

                                        update = "UPDATE article SET localimage=@url WHERE id=@id;";
                                        idb.AddParameter("@id", id);
                                        idb.AddParameter("@url", "http://investhype.com/artikelbilder/" + id + "-" + tt + ".jpg");
                                        idb.ExeCmd(update);

                                    }
                                    catch (Exception exc) { }
                                }
                            }
                        }
                    }
                    catch (Exception ex)
                    {
                    }
                }
            }

        }

        private void imageUpdateWorker_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            richTextBox1.AppendText("Article " + (string)e.UserState + " image updated \n");
            richTextBox1.SelectionStart = richTextBox1.Text.Length;
            richTextBox1.ScrollToCaret();
        }

        private void imageResizeWorker_DoWork(object sender, DoWorkEventArgs e)
        {
            IDBOperator idb = DBOperator.GetInstance();
            string sql = "SELECT  article.id,  article.title, article.image from article;"; // where localimage is null;";
            idb.AddParameter("@date", DateTime.Now);
            DataTable dt = idb.ReturnDataTable(sql);
            if (dt.Rows.Count > 0)
            {
                for (int i = 0; i < dt.Rows.Count; i++)
                {

                    string imageUrl = dt.Rows[i]["image"].ToString();
                    string id = dt.Rows[i]["id"].ToString();
                    if (imageUrl.Length > 0 && !imageUrl.Contains("Not Found"))
                    {

                        WebClient wc = new WebClient();
                        string imgg = HttpUtility.HtmlDecode(imageUrl);
                        try
                        {
                            wc.DownloadFile(imgg, "C:\\chrispersson.com\\artikelbilder\\" + id + "org.jpg");
                            Bitmap bp = (Bitmap)Bitmap.FromFile("C:\\chrispersson.com\\artikelbilder\\" + id + "org.jpg");
                            float width = 867;
                            if (bp.Width < width)
                            {
                                width = bp.Width;
                            }
                            float scale = (float)width / bp.Width;
                            float height = bp.Height * scale;
                            var bmp = new Bitmap((int)width, (int)height);
                            var graph = Graphics.FromImage(bmp);

                            // uncomment for higher quality output
                            graph.InterpolationMode = InterpolationMode.High;
                            graph.CompositingQuality = CompositingQuality.HighQuality;
                            graph.SmoothingMode = SmoothingMode.AntiAlias;
                            graph.DrawImage(bp, new Rectangle(0, 0, (int)width, (int)height));

                            System.Drawing.Imaging.Encoder myEncoder = System.Drawing.Imaging.Encoder.Quality;

                            EncoderParameters myEncoderParameters = new EncoderParameters(1);

                            EncoderParameter myEncoderParameter = new EncoderParameter(myEncoder,
                                90L);
                            myEncoderParameters.Param[0] = myEncoderParameter;
                            ImageCodecInfo jgpEncoder = GetEncoder(ImageFormat.Jpeg);
                            string tt = RemoveInvalidFilePathCharacters(dt.Rows[i]["title"].ToString(), "");
                            bmp.Save("C:\\chrispersson.com\\artikelbilder\\" + id + "-" + tt + ".jpg", jgpEncoder,
                                myEncoderParameters);
                            bmp.Dispose();
                            bp.Dispose();

                            string update = "UPDATE article SET localimage=@url WHERE id=@id;";
                            idb.AddParameter("@id", id);
                            idb.AddParameter("@url", "http://investhype.com/artikelbilder/" + id + "-" + tt + ".jpg");
                            idb.ExeCmd(update);
                            imageResizeWorker.ReportProgress(0, "http://investhype.com/artikelbilder/" + id + "-" + tt + ".jpg");
                        }
                        catch (Exception exc) { }
                    }
                }
            }
        }

        public static string RemoveInvalidFilePathCharacters(string filename, string replaceChar)
        {
            filename = filename.ToLower().Replace("å", "a").Replace("ä", "a").Replace("ö", "o");
            Regex rgx = new Regex("[^a-zA-Z0-9 -]");
            string rrr = rgx.Replace(filename, replaceChar);
            return rrr.Replace(" ", "-");
        }

        private ImageCodecInfo GetEncoder(ImageFormat format)
        {
            ImageCodecInfo[] codecs = ImageCodecInfo.GetImageDecoders();
            foreach (ImageCodecInfo codec in codecs)
            {
                if (codec.FormatID == format.Guid)
                {
                    return codec;
                }
            }
            return null;
        }

        private void imageResizeWorker_ProgressChanged(object sender, ProgressChangedEventArgs e)
        {
            if (e.ProgressPercentage == 0)
            {
                richTextBox1.AppendText((string)e.UserState + "\n");
                richTextBox1.SelectionStart = richTextBox1.Text.Length;
                richTextBox1.ScrollToCaret();
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            imageResizeWorker.RunWorkerAsync();
        }


    }

}
