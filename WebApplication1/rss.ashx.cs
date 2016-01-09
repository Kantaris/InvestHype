using Common.DataAccess;
using System;
using System.Collections.Generic;
using System.Data;
using System.Drawing;
using System.Drawing.Drawing2D;
using System.Drawing.Imaging;
using System.Globalization;
using System.IO;
using System.Linq;
using System.Net;
using System.ServiceModel.Syndication;
using System.Text;
using System.Web;
using System.Xml;

namespace WebApplication1
{
    /// <summary>
    /// Summary description for rss
    /// </summary>
    public class rss : IHttpHandler
    {


    public void ProcessRequest (HttpContext context) {
        context.Response.ContentType = "text/xml";

        SyndicationFeed myFeed = new SyndicationFeed();
        myFeed.Title = new TextSyndicationContent("InvestHype");
        DateTimeFormatInfo dfi = DateTimeFormatInfo.CurrentInfo;
        Calendar cal = dfi.Calendar;

        int week = cal.GetWeekOfYear(DateTime.Now, dfi.CalendarWeekRule, dfi.FirstDayOfWeek);
        myFeed.Description = new TextSyndicationContent("Veckans hetaste finansnyheter — Vecka " + week);
        myFeed.Language = "Swedish/Svenska";
        
        List<SyndicationItem> feedItems = new List<SyndicationItem>();
        IDBOperator idb = DBOperator.GetInstance();
        string sql = "SELECT  article.id,  article.categoryId, category.name as cName,  article.date,  article.title,  article.link, article.url, article.image,  article.summary,  article.sourceId, source.name as sName, article.hyped FROM article, category, source WHERE article.categoryId = category.id and article.sourceId = source.id and date >= DATE_SUB(@date,INTERVAL 7 DAY) ORDER BY article.hyped DESC LIMIT 10;";
        idb.AddParameter("@date", DateTime.Now);
        DataTable dt = idb.ReturnDataTable(sql);
        if (dt.Rows.Count > 0)
        {
            for (int i = 0; i < dt.Rows.Count; i++)
            {
                SyndicationItem item = new SyndicationItem();
                item.Title = new TextSyndicationContent(dt.Rows[i]["title"].ToString());
                string imageUrl = dt.Rows[i]["image"].ToString();
                string description = dt.Rows[i]["summary"].ToString();
                string id = dt.Rows[i]["id"].ToString();
                string article_url = dt.Rows[i]["url"].ToString();
                if (imageUrl.Length > 0 && !imageUrl.Contains("Not Found"))
                {
                    if (!File.Exists("C:\\chrispersson.com\\artikelbilder\\" + id + ".jpg"))
                    {
                        WebClient wc = new WebClient();
                        string imgg = HttpUtility.HtmlDecode(imageUrl);
                        wc.DownloadFile(imgg,"C:\\chrispersson.com\\artikelbilder\\" + id + "orig.jpg");
                        Bitmap bp = (Bitmap) Bitmap.FromFile("C:\\chrispersson.com\\artikelbilder\\" + id + "orig.jpg");
                        float width = 564;
                        float scale = (float) 564 / bp.Width;
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
                            80L);
                        myEncoderParameters.Param[0] = myEncoderParameter;
                        ImageCodecInfo jgpEncoder = GetEncoder(ImageFormat.Jpeg);
                        bmp.Save("C:\\chrispersson.com\\artikelbilder\\" + id + ".jpg", jgpEncoder,
                            myEncoderParameters);
                        bmp.Dispose();
                        bp.Dispose();
                        
                    }
                    item.Summary = new TextSyndicationContent(wrapWithImage(description, "http://investhype.com/artikelbilder/" + id + ".jpg", "http://investhype.com/nyheter" + article_url));
                }
                else
                {
                    item.Summary = new TextSyndicationContent(description);
                }
                DateTime dtime = (DateTime)dt.Rows[i]["date"];
                CultureInfo ci = new CultureInfo("sv-SE");
                string source_name = dt.Rows[i]["sName"].ToString();
                
                SyndicationPerson authInfo = new SyndicationPerson();
                SyndicationLink link = new SyndicationLink(new Uri("http://investhype.com/nyheter" + article_url));
                authInfo.Name = "Källa: " + source_name + " — " + dtime.ToString("yyyy-MM-dd HH:mm");
                item.Authors.Add(authInfo);
                item.PublishDate = DateTime.Now;
                item.Links.Add(link);  
                feedItems.Add(item);
                
            }
        }

        myFeed.Items = feedItems;        

        
        System.Xml.XmlWriter writer = XmlCDataWriter.Create(context.Response.Output);
        myFeed.SaveAsRss20(writer);
        writer.Close();
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

    private string wrapWithImage(string text, string image, string url)
    {
        return "<a href=\"" + url + "\"><img src=\"" + image + "\" style=\"width:100%;max-width:564px;\" /><br /></a>" + text;
    }

    public bool IsReusable
    {
        get
        {
            return false;
        }
    }
    }
    public class XmlCDataWriter : XmlTextWriter
    {
        public XmlCDataWriter(TextWriter w) : base(w) { }

        public XmlCDataWriter(Stream w, Encoding encoding) : base(w, encoding) { }

        public XmlCDataWriter(string filename, Encoding encoding) : base(filename, encoding) { }

        public override void WriteString(string text)
        {
            if (text.Contains("<"))
            {
                base.WriteCData(text);
            }
            else
            {
                base.WriteString(text);
            }
        }

    }
}