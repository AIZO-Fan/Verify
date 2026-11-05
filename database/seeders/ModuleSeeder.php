<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            // ----------------------------------------------------------------
            // 1. Phishing Scams
            // ----------------------------------------------------------------
            [
                'title'        => 'Understanding Phishing Scams',
                'slug'         => 'understanding-phishing-scams',
                'description'  => 'Learn how phishing attacks work, how to spot deceptive emails, and the steps you can take to protect your personal information from cyber criminals.',
                'category'     => 'Phishing Scams',
                'is_published' => true,
                'content'      => <<<HTML
<h3>Introduction</h3>
<p>Phishing is one of the oldest and most effective cybercrime techniques in existence. Despite advances in spam filters and security software, phishing attacks continue to claim millions of victims each year because they exploit the most vulnerable element of any security system: human psychology. Understanding how phishing works is the first and most important step toward protecting yourself online.</p>

<h3>How Phishing Works</h3>
<p>A phishing attack begins when a cybercriminal crafts a deceptive message—usually an email, but sometimes an SMS or social media message—designed to look as though it comes from a trusted source such as a bank, a government agency, or a popular online service. The message typically creates a sense of urgency: your account is locked, a suspicious transaction was detected, or you must verify your identity immediately.</p>
<p>The link embedded in the message leads to a fake website that is a pixel-perfect copy of the legitimate one. When you enter your credentials, they are silently captured by the attacker, who then uses them to access your real account, steal money, or sell the data on underground markets.</p>

<h3>Common Red Flags</h3>
<ul>
  <li><strong>Urgency and pressure:</strong> Phrases like "Your account will be suspended in 24 hours" are designed to stop you thinking clearly.</li>
  <li><strong>Mismatched sender address:</strong> The display name says "PayPal Support" but the actual email address is something like <code>no-reply@paypa1-secure.net</code>.</li>
  <li><strong>Suspicious links:</strong> Hovering over a link reveals a URL that does not match the supposed sender's domain.</li>
  <li><strong>Generic greetings:</strong> Legitimate services typically address you by your full name, not "Dear Valued Customer".</li>
  <li><strong>Grammar and spelling mistakes:</strong> While sophisticated phishing emails are now well-written, many still contain subtle errors.</li>
  <li><strong>Requests for sensitive data:</strong> No legitimate organization will ask for your password, PIN, or full credit card number via email.</li>
</ul>

<h3>A Fictional Example</h3>
<p>Imagine a person named <strong>Alex Tan</strong> (fictional) receives an email claiming to be from "SecureBank Online Services." The email states that an unauthorized login attempt was detected and instructs Alex to click a link to verify their identity within 12 hours or face permanent account suspension. The link goes to <code>securebank-online-verify.com</code>—not the bank's real domain. Alex, panicking, enters their username, password, and one-time SMS code. Within minutes, the attacker uses those credentials to transfer funds out of Alex's account.</p>

<h3>Prevention Methods</h3>
<ul>
  <li>Always verify the sender's email address carefully, not just the display name.</li>
  <li>Never click links in unsolicited emails. Navigate directly to the website by typing the URL in your browser.</li>
  <li>Enable multi-factor authentication (MFA) on all your important accounts—even if a password is stolen, MFA adds a critical second barrier.</li>
  <li>Use a password manager, which will refuse to autofill credentials on a fake domain.</li>
  <li>Report suspicious emails to your email provider and, if relevant, to the organization being impersonated.</li>
  <li>Keep your browser and operating system updated so security patches are applied promptly.</li>
</ul>

<h3>Key Takeaways</h3>
<p>Phishing succeeds through deception and urgency. The best defenses are <strong>slow, critical thinking</strong> and <strong>technical safeguards</strong> like MFA and password managers. When in doubt, go directly to the official website or call the organization's official support line. Never trust a link that arrives unsolicited.</p>
HTML,
            ],

            // ----------------------------------------------------------------
            // 2. Online Shopping Scams
            // ----------------------------------------------------------------
            [
                'title'        => 'Spotting Online Shopping Scams',
                'slug'         => 'spotting-online-shopping-scams',
                'description'  => 'Discover how fraudulent e-commerce sites and fake sellers operate, and learn the key checks to perform before you hand over your payment details.',
                'category'     => 'Online Shopping Scams',
                'is_published' => true,
                'content'      => <<<HTML
<h3>Introduction</h3>
<p>The explosive growth of e-commerce has been accompanied by an equally explosive growth in online shopping fraud. Fake storefronts, counterfeit goods, and "too good to be true" deals have collectively cost consumers billions of dollars. Whether you are shopping on a marketplace like a large auction site or visiting a standalone webstore, knowing the warning signs of a scam can save you significant money and frustration.</p>

<h3>How Online Shopping Scams Work</h3>
<p>Fraudsters typically operate in two ways. The first is the <strong>fake storefront</strong>: a professional-looking website that accepts payment but either ships counterfeit goods, ships nothing at all, or disappears after collecting money. These sites often run paid advertisements to appear prominently in search results, lending them false credibility.</p>
<p>The second method involves <strong>fake sellers on legitimate marketplaces</strong>. A scammer creates a new seller account, lists high-demand items at a steep discount, collects payments, and then disappears or ships empty boxes before the marketplace can intervene.</p>

<h3>Common Red Flags</h3>
<ul>
  <li><strong>Prices that seem impossibly low:</strong> A brand-new flagship smartphone listed at 30% of its retail price is almost certainly a scam.</li>
  <li><strong>No physical address or contact details:</strong> Legitimate businesses display verifiable contact information.</li>
  <li><strong>Unusual payment methods:</strong> Requests for wire transfers, cryptocurrency, or gift cards offer no consumer protection.</li>
  <li><strong>Sparse or recycled reviews:</strong> Review sections that only contain five-star ratings posted on the same date are fabricated.</li>
  <li><strong>Poorly written product descriptions:</strong> Machine-translated text with awkward phrasing is a red flag.</li>
  <li><strong>No HTTPS:</strong> A padlock in the browser address bar is mandatory—its absence means your payment data is transmitted in plain text.</li>
</ul>

<h3>A Fictional Example</h3>
<p><strong>Priya Lakshmanan</strong> (fictional) finds an Instagram advertisement for a designer handbag at 70% off from a site called <code>luxebagsdeal-store.com</code>. The site looks polished, has glowing reviews, and accepts PayPal. Priya orders two bags. Three weeks later, nothing arrives. She visits the site again to find it offline. The PayPal payment went to a personal account, and the dispute process reveals the seller had no history. Priya loses her money and the seller is unreachable.</p>

<h3>Prevention Methods</h3>
<ul>
  <li>Research unknown stores using independent review sites before purchasing.</li>
  <li>Check the domain registration date using a WHOIS tool—sites registered within the last few months selling major brands are suspicious.</li>
  <li>Prefer paying with a credit card or PayPal (Goods & Services), which offer chargeback protection.</li>
  <li>Search for the product image using reverse image search to see if it appears on legitimate stock-photo sites.</li>
  <li>Confirm a physical return address is listed and test the customer service contact before purchasing.</li>
</ul>

<h3>Key Takeaways</h3>
<p>If a deal feels too good to be true, it almost certainly is. Always research unknown sellers, pay with protected methods, and trust your instincts when something feels off about a site or listing.</p>
HTML,
            ],

            // ----------------------------------------------------------------
            // 3. Investment Scams
            // ----------------------------------------------------------------
            [
                'title'        => 'Recognizing Investment Scams',
                'slug'         => 'recognizing-investment-scams',
                'description'  => 'Understand how fraudulent investment schemes lure victims with promises of high returns and learn how to protect your savings from financial predators.',
                'category'     => 'Investment Scams',
                'is_published' => true,
                'content'      => <<<HTML
<h3>Introduction</h3>
<p>Investment scams have devastated the savings of countless individuals worldwide. From classic Ponzi schemes to modern cryptocurrency pump-and-dump operations, these frauds exploit the universal desire for financial growth. The sophistication of today's investment scammers—armed with professional-looking websites, fabricated track records, and social proof—makes them extraordinarily dangerous.</p>

<h3>How Investment Scams Work</h3>
<p>The hallmark of every investment scam is the promise of <strong>unusually high, guaranteed returns</strong> with little or no risk. Early investors often receive genuine payouts—funded by money from newer investors—which builds trust and encourages further investment and referrals. This is the classic Ponzi structure. Eventually, the scheme collapses when the operator can no longer attract enough new money to pay existing investors.</p>
<p>Crypto investment scams follow a similar pattern but add technical complexity. Victims are shown a custom trading dashboard displaying impressive portfolio growth—all of it fabricated. When they attempt to withdraw profits, they are told they must first pay "taxes" or "withdrawal fees," extracting even more money before the scammer disappears entirely.</p>

<h3>Common Red Flags</h3>
<ul>
  <li><strong>Guaranteed returns:</strong> No legitimate investment can guarantee profits. Markets always carry risk.</li>
  <li><strong>Pressure to recruit others:</strong> Multi-level structures where your returns depend on referrals are almost always pyramid schemes.</li>
  <li><strong>Unlicensed operators:</strong> Always verify an investment firm's license with your country's financial regulator.</li>
  <li><strong>Complex or secretive strategies:</strong> Legitimate fund managers explain how they invest. Vague claims of "proprietary algorithms" should raise alarms.</li>
  <li><strong>Difficulty withdrawing funds:</strong> Any unexpected obstacles when you try to retrieve your money are a serious warning sign.</li>
  <li><strong>Celebrity endorsements:</strong> Fabricated endorsements from famous investors or public figures are commonly used to build credibility.</li>
</ul>

<h3>A Fictional Example</h3>
<p><strong>Marcus Osei</strong> (fictional) is approached on LinkedIn by someone claiming to be a wealth manager offering a private crypto arbitrage fund guaranteeing 15% monthly returns. Marcus is shown a slick website with live trading charts and testimonials. He invests $5,000 and watches his balance "grow" to $12,000 within two months. When he tries to withdraw, he is told he must pay a 20% "government tax" of $2,400 before the funds can be released. After paying, the account is frozen and the manager stops responding.</p>

<h3>Prevention Methods</h3>
<ul>
  <li>Always verify the registration of any investment firm with your national financial regulator before investing.</li>
  <li>Be deeply skeptical of any investment promising guaranteed, high, or risk-free returns.</li>
  <li>Never invest money you cannot afford to lose, especially on the advice of someone you have only met online.</li>
  <li>Consult an independent, licensed financial advisor before committing large sums.</li>
  <li>Search for the company name along with terms like "scam," "review," or "complaint" before engaging.</li>
</ul>

<h3>Key Takeaways</h3>
<p>Legitimate investments carry risk and never promise guaranteed returns. The combination of urgency, secrecy, and extraordinary profit claims is the universal signature of a scam. Protecting your savings begins with healthy skepticism and verifying every credential independently.</p>
HTML,
            ],

            // ----------------------------------------------------------------
            // 4. Social Engineering
            // ----------------------------------------------------------------
            [
                'title'        => 'The Art of Social Engineering',
                'slug'         => 'the-art-of-social-engineering',
                'description'  => 'Explore how attackers manipulate human psychology to bypass security controls, and learn the mindset and practical habits that make you resilient to manipulation.',
                'category'     => 'Social Engineering',
                'is_published' => true,
                'content'      => <<<HTML
<h3>Introduction</h3>
<p>Social engineering is the art of manipulating people into divulging confidential information or performing actions that compromise security. Unlike technical hacking, social engineering requires no code—only persuasion, patience, and an understanding of human psychology. It is the foundation of the majority of successful cyberattacks, from nation-state espionage to everyday fraud.</p>

<h3>How Social Engineering Works</h3>
<p>Social engineers exploit fundamental human traits: the desire to be helpful, the tendency to trust authority, the fear of negative consequences, and the instinct to reciprocate kindness. Common techniques include:</p>
<ul>
  <li><strong>Pretexting:</strong> Creating a fabricated scenario to extract information. For example, impersonating an IT technician who needs your login to "fix a critical system issue."</li>
  <li><strong>Baiting:</strong> Leaving infected USB drives in public places, knowing that curious people will plug them in.</li>
  <li><strong>Quid pro quo:</strong> Offering something (e.g., a software download or a gift card) in exchange for credentials or access.</li>
  <li><strong>Vishing:</strong> Voice phishing—making calls while impersonating bank fraud departments, government agencies, or tech support teams.</li>
  <li><strong>Tailgating:</strong> Physically following an authorized person through a secured door.</li>
</ul>

<h3>Common Red Flags</h3>
<ul>
  <li>Unsolicited contact from "authorities" requesting immediate action or sensitive data.</li>
  <li>Requests that bypass normal procedures ("just this once" or "it's an emergency").</li>
  <li>Callers or senders who can't verify their identity through official channels.</li>
  <li>Offers that arrive without context—free gifts, prizes, or rewards you didn't initiate.</li>
  <li>Pressure not to verify the request with others: "This needs to stay confidential."</li>
</ul>

<h3>A Fictional Example</h3>
<p><strong>Sarah Whitmore</strong> (fictional), an accounts payable clerk, receives a phone call from someone claiming to be the company's IT director. The caller says a critical server patch is being applied and that Sarah must provide her network login to prevent data loss. The caller sounds authoritative, references her manager's name (found on LinkedIn), and says the CEO has already been briefed. Sarah provides her credentials. The caller is a social engineer who now has valid network access.</p>

<h3>Prevention Methods</h3>
<ul>
  <li>Establish and follow a strict verification protocol: always call back on a known, official number before acting on unsolicited requests.</li>
  <li>Train employees to pause and question unusual requests, regardless of the apparent seniority of the requester.</li>
  <li>Implement a "no credentials over the phone" policy for all IT departments.</li>
  <li>Be cautious about how much personal and professional information you share publicly on social media—it fuels pretexting.</li>
  <li>Foster a culture where it is acceptable to say "I need to verify this first" without fear of appearing unhelpful.</li>
</ul>

<h3>Key Takeaways</h3>
<p>Social engineering is a people problem, not just a technology problem. The most robust technical defenses can be bypassed by a confident, well-prepared attacker. Building a culture of healthy skepticism and verification is your strongest defense against manipulation.</p>
HTML,
            ],

            // ----------------------------------------------------------------
            // 5. Fake Websites
            // ----------------------------------------------------------------
            [
                'title'        => 'Identifying Fake Websites',
                'slug'         => 'identifying-fake-websites',
                'description'  => 'Learn the technical and visual clues that distinguish fraudulent websites from legitimate ones, and how to verify a site before entering personal data.',
                'category'     => 'Fake Websites',
                'is_published' => true,
                'content'      => <<<HTML
<h3>Introduction</h3>
<p>Fraudulent websites are the digital storefronts of cybercrime. With modern website builders and free SSL certificates, any attacker can create a convincing fake bank, government portal, or online store in minutes. Knowing how to scrutinize a website before interacting with it is an essential digital literacy skill.</p>

<h3>How Fake Websites Work</h3>
<p>Fake websites are typically created to serve one of three purposes: <strong>credential harvesting</strong> (stealing your login details), <strong>financial fraud</strong> (collecting payment for goods never delivered), or <strong>malware distribution</strong> (tricking visitors into downloading infected files).</p>
<p>Attackers promote these sites through phishing emails, paid search advertising, social media posts, and even compromised legitimate websites that redirect visitors. Some fake sites copy entire pages from the real organization's website to appear identical.</p>

<h3>Common Red Flags</h3>
<ul>
  <li><strong>Suspicious domain names:</strong> Look for subtle misspellings (<code>paypa1.com</code>), extra words (<code>amazon-secure-login.com</code>), or unusual top-level domains (<code>.xyz</code>, <code>.tk</code>).</li>
  <li><strong>Missing or mismatched SSL certificate:</strong> Click the padlock icon and verify the certificate was issued to the correct organization name.</li>
  <li><strong>No "About Us" or "Contact" page:</strong> Legitimate businesses have verifiable contact information.</li>
  <li><strong>Recently registered domain:</strong> A brand-new domain claiming to be a long-established company is a major warning sign.</li>
  <li><strong>Broken links and poor design:</strong> Hastily constructed fakes often have non-functional navigation or low-resolution logos.</li>
  <li><strong>Unexpected pop-ups or download prompts:</strong> Legitimate sites rarely require you to download something to continue.</li>
</ul>

<h3>A Fictional Example</h3>
<p><strong>Daniel Ferreira</strong> (fictional) searches for his country's income tax filing portal but clicks a paid advertisement for <code>taxreturn-portal-official.com</code> instead of the government's real site. The site looks identical to the official portal. Daniel enters his national ID number, date of birth, and bank account details to "set up his refund." These details are immediately captured by the scammers, who use them to file a fraudulent tax return and redirect his real refund to their own account.</p>

<h3>Prevention Methods</h3>
<ul>
  <li>Always type government and banking URLs directly into the browser address bar rather than clicking search results or ads.</li>
  <li>Use a reputable URL checker or browser security extension that flags known malicious sites.</li>
  <li>Verify the domain's registration age and owner using a WHOIS lookup service.</li>
  <li>Check that the SSL certificate is issued to the organization you expect—not just that a padlock is present.</li>
  <li>Bookmark frequently visited sensitive sites (banks, government portals) so you never have to search for them.</li>
</ul>

<h3>Key Takeaways</h3>
<p>A padlock icon alone does not mean a site is safe—it only means the connection is encrypted. Always verify the domain name carefully, check the certificate details, and prefer to navigate to sensitive sites directly rather than through search results or links.</p>
HTML,
            ],

            // ----------------------------------------------------------------
            // 6. Account Takeover
            // ----------------------------------------------------------------
            [
                'title'        => 'Preventing Account Takeover',
                'slug'         => 'preventing-account-takeover',
                'description'  => 'Understand how attackers seize control of your online accounts and the multi-layered defenses that keep your digital identity secure.',
                'category'     => 'Account Takeover',
                'is_published' => true,
                'content'      => <<<HTML
<h3>Introduction</h3>
<p>Account takeover (ATO) occurs when a cybercriminal successfully gains unauthorized access to someone else's online account—be it email, banking, social media, or e-commerce. Once inside, the attacker can steal money, extract sensitive personal data, impersonate the victim, or use the account as a launchpad for further attacks against the victim's contacts.</p>

<h3>How Account Takeovers Happen</h3>
<p>The most common methods include:</p>
<ul>
  <li><strong>Credential stuffing:</strong> Attackers take username/password combinations leaked in past data breaches and automatically try them across hundreds of websites, exploiting password reuse.</li>
  <li><strong>Phishing:</strong> Tricking the user into entering their credentials on a fake login page.</li>
  <li><strong>SIM swapping:</strong> Convincing a mobile carrier to transfer the victim's phone number to an attacker-controlled SIM, intercepting SMS-based one-time passwords.</li>
  <li><strong>Malware:</strong> Keyloggers installed on a device that silently record every keystroke, including passwords.</li>
  <li><strong>Brute force:</strong> Automatically guessing common passwords, particularly on accounts with no lockout mechanism.</li>
</ul>

<h3>Common Red Flags</h3>
<ul>
  <li>Unexpected login notifications from unfamiliar devices or locations.</li>
  <li>Password reset emails or SMS codes you did not request.</li>
  <li>Contacts reporting strange messages sent from your account.</li>
  <li>Being suddenly logged out of accounts on your own device.</li>
  <li>Unfamiliar charges appearing on linked payment methods.</li>
</ul>

<h3>A Fictional Example</h3>
<p><strong>Yuna Park</strong> (fictional) uses the same password for her email and her online shopping account. When a large retailer suffers a data breach, Yuna's credentials are included in the leaked database. An attacker purchases the breach data and uses an automated tool to log into Yuna's email. From there, they reset passwords for her other accounts, access her digital wallet, and make several unauthorized purchases before Yuna notices anything is wrong three days later.</p>

<h3>Prevention Methods</h3>
<ul>
  <li>Use a unique, complex password for every account—a password manager makes this practical.</li>
  <li>Enable multi-factor authentication (MFA) everywhere it is available. Authenticator apps (e.g., Google Authenticator, Authy) are more secure than SMS-based MFA.</li>
  <li>Regularly check <em>Have I Been Pwned</em> to see if your email has appeared in a data breach.</li>
  <li>Set up login alerts on important accounts so you are notified of any new sign-in.</li>
  <li>Be cautious about SIM swapping: consider adding a carrier account PIN and asking your carrier about port-out protection.</li>
  <li>Keep devices free of malware by using reputable security software and avoiding suspicious downloads.</li>
</ul>

<h3>Key Takeaways</h3>
<p>Password reuse is the single biggest enabler of account takeover. Using unique passwords and enabling MFA on every account significantly raises the cost of an attack—so much so that most opportunistic attackers will move on to easier targets.</p>
HTML,
            ],

            // ----------------------------------------------------------------
            // 7. OTP Scams
            // ----------------------------------------------------------------
            [
                'title'        => 'OTP Scams: When Two-Factor Authentication Fails',
                'slug'         => 'otp-scams-when-two-factor-authentication-fails',
                'description'  => 'Discover how scammers trick victims into handing over one-time passwords and learn advanced strategies to keep your MFA codes safe.',
                'category'     => 'OTP Scams',
                'is_published' => true,
                'content'      => <<<HTML
<h3>Introduction</h3>
<p>One-time passwords (OTPs) were introduced as a powerful second layer of security, requiring attackers to possess not just your password but also your phone or authenticator app. However, cybercriminals have developed sophisticated social engineering techniques to steal these codes in real time, effectively bypassing multi-factor authentication entirely.</p>

<h3>How OTP Scams Work</h3>
<p>OTP scams almost always involve <strong>real-time social engineering</strong>. The attacker already has the victim's username and password (obtained through a previous breach or phishing attack). They initiate a login on the real website, which triggers an OTP to be sent to the victim's phone. Simultaneously, the attacker contacts the victim—by phone, email, or SMS—posing as a representative of the targeted service and urgently requests the OTP, claiming it is needed for verification or to prevent a security threat.</p>
<p>Because the OTP arrives at the same moment as the call, the timing feels authentic and the victim believes the representative is legitimate. The moment the OTP is shared, the attacker uses it to complete the login.</p>

<h3>Common Red Flags</h3>
<ul>
  <li>Receiving an OTP you did not request—this means someone else is trying to log into your account.</li>
  <li>Being called, messaged, or emailed immediately after an OTP arrives, asking you to read it out or forward it.</li>
  <li>The caller claims to be from your bank, mobile provider, or a government agency and says the code is "for your security."</li>
  <li>Pressure to share the code quickly before it expires.</li>
  <li>The legitimate organization's OTP message itself says "Do not share this code with anyone"—a warning that scammers hope you ignore.</li>
</ul>

<h3>A Fictional Example</h3>
<p><strong>Farah Ibrahim</strong> (fictional) suddenly receives a text: "Your bank OTP is 847291. Do not share this with anyone." Seconds later, her phone rings. The caller introduces himself as a fraud prevention officer from her bank, saying they detected a suspicious login and need her to verify the OTP to cancel the transaction. Trusting the timely, official-sounding call, Farah reads out the code. The "fraud officer" is actually the attacker who just used that OTP to log into her banking app and authorize a fund transfer.</p>

<h3>Prevention Methods</h3>
<ul>
  <li><strong>Never share an OTP with anyone</strong>, regardless of who they claim to be. No legitimate organization will ever ask for it.</li>
  <li>If you receive an unexpected OTP, treat it as a security alert: someone has your password. Change it immediately.</li>
  <li>Hang up unsolicited calls and call back using the official number on the company's website or the back of your card.</li>
  <li>Where possible, switch from SMS-based OTP to an authenticator app, which is harder to intercept.</li>
  <li>Consider using hardware security keys (e.g., YubiKey) for the highest level of account protection.</li>
</ul>

<h3>Key Takeaways</h3>
<p>An OTP is a secret token—the moment you share it with another person, its security guarantee is gone. The rule is absolute: <strong>no one legitimate will ever ask you for your OTP.</strong> If you receive an unexpected code, it is a warning, not an invitation to cooperate with a stranger.</p>
HTML,
            ],

            // ----------------------------------------------------------------
            // 8. Digital Identity Theft
            // ----------------------------------------------------------------
            [
                'title'        => 'Digital Identity Theft: Protecting Who You Are Online',
                'slug'         => 'digital-identity-theft-protecting-who-you-are-online',
                'description'  => 'Explore how criminals steal and misuse digital identities, the long-lasting harm it causes, and the proactive measures that give you control over your personal data.',
                'category'     => 'Digital Identity Theft',
                'is_published' => true,
                'content'      => <<<HTML
<h3>Introduction</h3>
<p>Digital identity theft occurs when a criminal obtains sufficient personal information about you to impersonate you online. This can include your name, address, national identification number, date of birth, banking details, or combinations of these. The consequences range from fraudulent credit applications and tax refund theft to blackmail and reputational damage—all of which can take years to fully resolve.</p>

<h3>How Digital Identity Theft Works</h3>
<p>Criminals assemble identity profiles through multiple channels:</p>
<ul>
  <li><strong>Data breaches:</strong> Large-scale leaks from companies expose usernames, passwords, addresses, and financial data for millions of people simultaneously.</li>
  <li><strong>Social media scraping:</strong> Public profiles reveal birthdays, hometowns, family members, workplaces, and security question answers.</li>
  <li><strong>Phishing:</strong> Victims are tricked into entering personal information on fake websites.</li>
  <li><strong>Dark web markets:</strong> Stolen data is bought and sold in bulk, often for just a few dollars per record.</li>
  <li><strong>Physical methods:</strong> Mail theft and dumpster diving can yield bank statements, utility bills, and other identifying documents.</li>
</ul>

<h3>Common Red Flags</h3>
<ul>
  <li>Receiving bills or collection notices for accounts you never opened.</li>
  <li>Unexplained withdrawals or transactions on your bank or credit card statements.</li>
  <li>Being denied credit for no apparent reason, or finding unfamiliar accounts on your credit report.</li>
  <li>Receiving tax documents for income you did not earn, or being told a return has already been filed in your name.</li>
  <li>Contacts telling you they received messages from you that you never sent.</li>
  <li>Notification from a service that your email or personal data was included in a data breach.</li>
</ul>

<h3>A Fictional Example</h3>
<p><strong>Carlos Mendez</strong> (fictional) receives a letter from a bank informing him that his credit card application—which he never submitted—has been approved. When he checks his credit report, he discovers three new credit accounts opened in his name over the past month, totaling over $20,000 in credit. His personal information was likely purchased from a dark web market following a data breach at a subscription service he used years ago. Carlos must now spend months working with credit bureaus, banks, and law enforcement to have the fraudulent accounts removed and his credit score restored.</p>

<h3>Prevention Methods</h3>
<ul>
  <li>Regularly check your credit report for unfamiliar accounts and inquiries.</li>
  <li>Consider placing a credit freeze at credit bureaus, which prevents new credit from being opened in your name without your explicit authorization.</li>
  <li>Monitor data breach notifications—sign up for alerts via services like Have I Been Pwned.</li>
  <li>Minimize the personal information you share publicly on social media.</li>
  <li>Shred physical documents containing personal information before disposal.</li>
  <li>Use unique, strong passwords for every account and enable MFA to limit the damage from any single breach.</li>
  <li>Be vigilant about which organizations you share your government ID or financial data with, and verify their legitimacy first.</li>
</ul>

<h3>Key Takeaways</h3>
<p>Your digital identity is a valuable asset that criminals actively work to steal. The best protection is a combination of proactive monitoring, limiting your personal data footprint, and responding quickly when you spot warning signs. The sooner you act, the less damage identity thieves can do.</p>
HTML,
            ],
        ];

        foreach ($modules as $moduleData) {
            Module::firstOrCreate(
                ['slug' => $moduleData['slug']],
                $moduleData
            );
        }
    }
}
