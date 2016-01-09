using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Web;

namespace WebApplication1
{
    public static class WebClientExtensions
    {
        public static string DownloadStringAwareOfEncoding(this WebClient webClient, string uri)
        {
            var rawData = webClient.DownloadData(uri);
            var encoding = WebUtils.GetEncodingFrom(webClient.ResponseHeaders, Encoding.UTF8);
            return encoding.GetString(rawData);
        }
    }
}