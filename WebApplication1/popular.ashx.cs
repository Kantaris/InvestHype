using Common.DataAccess;
using System;
using System.Collections.Generic;
using System.Data;
using System.Globalization;
using System.Linq;
using System.ServiceModel.Syndication;
using System.Web;

namespace WebApplication1
{
    /// <summary>
    /// Summary description for popular
    /// </summary>
    public class popular : IHttpHandler
    {

        public void ProcessRequest(HttpContext context)
        {
            context.Response.ContentType = "text/xml";

            SyndicationFeed myFeed = new SyndicationFeed();
            myFeed.Title = new TextSyndicationContent("InvestHype");
            DateTimeFormatInfo dfi = DateTimeFormatInfo.CurrentInfo;
            Calendar cal = dfi.Calendar;

            int week = cal.GetWeekOfYear(DateTime.Now, dfi.CalendarWeekRule, dfi.FirstDayOfWeek);
            myFeed.Description = new TextSyndicationContent("De hetaste finansnyheterna just nu!");
            myFeed.Language = "Swedish/Svenska";

            List<SyndicationItem> feedItems = new List<SyndicationItem>();
            IDBOperator idb = DBOperator.GetInstance();
            string sql = "SELECT  popular.id as pid, popular.articleId, article.id as aid, article.hashtags, article.categoryId, category.name as cName,  article.date,  article.title,  article.link,  article.image, article.url, article.summary,  article.sourceId, source.name as sName, article.hyped FROM article, category, source, popular WHERE popular.articleId = article.id and article.categoryId = category.id and article.sourceId = source.id ORDER BY popular.id DESC LIMIT 10;";
            idb.AddParameter("@date", DateTime.Now);
            DataTable dt = idb.ReturnDataTable(sql);
            if (dt.Rows.Count > 0)
            {
                for (int i = 0; i < dt.Rows.Count; i++)
                {
                    SyndicationItem item = new SyndicationItem();
                    item.Title = new TextSyndicationContent(dt.Rows[i]["title"].ToString());
                    string imageUrl = HttpUtility.HtmlDecode(dt.Rows[i]["image"].ToString());
                    string hashtags = dt.Rows[i]["hashtags"].ToString();
                    string description = dt.Rows[i]["summary"].ToString() + " " + hashtags;
                    string id = dt.Rows[i]["aid"].ToString();
                    item.Summary = new TextSyndicationContent(description);
                    DateTime dtime = (DateTime)dt.Rows[i]["date"];
                    CultureInfo ci = new CultureInfo("sv-SE");
                    string source_name = dt.Rows[i]["sName"].ToString();
                    string article_url = dt.Rows[i]["url"].ToString();
                    SyndicationPerson authInfo = new SyndicationPerson();
                    SyndicationLink link = new SyndicationLink(new Uri("http://investhype.com/nyheter" + article_url));
                    authInfo.Name = "Källa: " + source_name + " — " + dtime.ToString("yyyy-MM-dd HH:mm");
                    item.PublishDate = DateTime.Now;
                    item.Links.Add(link);
                    item.Authors.Add(authInfo);
                    feedItems.Add(item);

                }
            }

            myFeed.Items = feedItems;


            System.Xml.XmlWriter writer = XmlCDataWriter.Create(context.Response.Output);
            myFeed.SaveAsAtom10(writer);
            writer.Close();
        }

        public bool IsReusable
        {
            get
            {
                return false;
            }
        }
    }
}