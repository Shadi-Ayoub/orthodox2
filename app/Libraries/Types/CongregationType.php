<?php
declare(strict_types=1);

namespace App\Libraries\Types;

/** 
 * Structured Example:
*      Religion: Christianity
*           Denomination: Protestant
*                Regional Variation: N/A (not always applicable)
*                     Local Community: Community Bible Church
*                          Sub-Groups: Youth Ministry, Women's Fellowship
*/

class CongregationType {
    /**
     * The top-level category that defines the broad religious tradition.
     * Examples include Christianity, Islam, Hinduism, Buddhism, Judaism, Sikhism, etc. 
     * This level helps to broadly categorize the major faith systems.
     */
    public string $religion; // Christianity

    /**
     * Under each religion, there can be various denominations, sects, or branches that represent significant theological, liturgical, or cultural differences within the broad religious tradition. For example:
     * - Christianity: Catholic, Orthodox, Protestant (Baptist, Methodist, Lutheran, etc.)
     * - Islam: Sunni, Shia Buddhism: Theravada, Mahayana, Vajrayana
     * - Hinduism: Vaishnavism, Shaivism, Shaktism, Smartism
     * - Judaism: Orthodox, Conservative, Reform
     */
    public string $denomination; // Protestant

    /**
     * Some religions have variations or practices that are specific to certain regions or cultures. This can be an optional layer if applicable:
     * - Different practices or rites within the same denomination based on cultural or regional preferences.
     * - Language-specific congregations within a broader religious community.
     */
    public string $regional_variation; // N/A (not always applicable)

    /**
     * The specific community or congregation level. This could be the local church, mosque, synagogue, temple, gurdwara, etc., where members gather for worship, prayer, and community activities. Each congregation would have a unique identifier and possibly characteristics such as:
     * - Name
     * - Location (address, city, state, country)
     * - Contact information
     * - Service times
     * - Community programs
     */
    public string $local_community; // Community Bible Church

    /**
     * Within each congregation, there may be various sub-groups or ministries that cater to 
     * specific demographic groups (youth, women, men, families) or interests (outreach, 
     * education, social services). This level allows for detailed organization of the congregation's 
     * internal structure and activities.
     */
    public string $sub_group; // Youth Ministry, Women's Fellowship
}